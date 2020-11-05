<?php

namespace App\Http\Controllers;

use App\Components\Options;
use App\Exports\BookmarksExport;
use App\Http\Requests\BookmarkRequest;
use App\Http\Requests\DeleteBookmarkRequest;
use App\Models\Bookmark;
use App\Services\GettingDataService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DataController extends Controller
{
    public function formSubmit(BookmarkRequest $request)
    {
        $url = $request->get('url');
        $service = new GettingDataService($url);
        $validUrl = $service->checkUrl($url);
        if (!$validUrl) {
            return back()->with('valid', 'Введите валидный адрес сайта');
        }
        $file_headers = @get_headers($validUrl);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            return back()->with('valid', 'Введите валидный адрес сайта');
        }
        $project_id_exist = Bookmark::where('url', $url)->first();
        if ($project_id_exist) {
            return back()->with('error', 'Данный URL уже используется');
        }

        $favicon = $service->getPageFavicon($validUrl);
        $title = $service->getPageTitle($validUrl);
        $keywords = $service->getMetaKeywords($validUrl);
        $description = $service->getMetaDescription($validUrl);

        $bookmark = new Bookmark();
        $bookmark->url = $validUrl;
        $bookmark->favicon = $favicon;
        $bookmark->title = $title;
        $bookmark->meta_key = $keywords;
        $bookmark->meta_desc = $description;
        $bookmark->save();
        return redirect("bookmark/{$bookmark->id}");
    }

    public function viewBookmark($bookmark)
    {
        $values = Bookmark::where('id', $bookmark)->first();
        return view('bookmark', compact('values'));
    }

    public function allBookmarks($sort)
    {
        switch ($sort) {
            case 'desc':
                $column = 'created_at';
                $sortby = 'desc';
                break;
            case 'urlDesc':
                $column = 'url';
                $sortby = 'desc';
                break;
            case 'urlAsc':
                $column = 'url';
                $sortby = 'asc';
                break;
            case 'titleDesc':
                $column = 'title';
                $sortby = 'desc';
                break;
            case 'titleAsc':
                $column = 'title';
                $sortby = 'asc';
                break;
            default:
                $column = 'created_at';
                $sortby = 'asc';
                break;
        }
        $values = DB::table('bookmarks')->orderBy($column, $sortby)->paginate(2);
        return view('allBookmarks', compact('values'));
    }

    public function export()
    {
        return Excel::download(new BookmarksExport(), 'bookmarks.xlsx');
    }

    public function delete(DeleteBookmarkRequest $request)
    {
        if($request->password !== Options::SECURITY_SUPER_PASSWORD) {
            return back()->with('errorPassword', 'Введите правильный пароль');
        }
        $value = Bookmark::where('id', $request->id_hid)->first();
        $value->delete();
        return redirect('/');
    }
}
