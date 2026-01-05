<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()->pluck('content', 'id');

        $query = $this->buildFilteredQuery($request);

        $contacts = $query->latest()->paginate(7)->withQueryString();

        return view('admin', compact('contacts', 'categories'));
    }

    public function show(Contact $contact)
    {
        $contact->load('category');
        return view('admin_show', compact('contact'));
    }

    public function destroy(Contact $contact, Request $request)
    {
        $contact->delete();

        return redirect()
            ->route('admin.search', $request->query())
            ->with('message', '削除しました');
    }

    public function export(Request $request)
    {
        $query = $this->buildFilteredQuery($request);

        $fileName = 'contacts_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');

            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, [
                'ID',
                '姓',
                '名',
                '性別',
                'メールアドレス',
                '電話番号',
                '住所',
                '建物名',
                'お問い合わせの種類',
                'お問い合わせ内容',
                '作成日',
            ]);

            $query->latest()->chunk(500, function ($contacts) use ($out) {
                foreach ($contacts as $c) {
                    $genderLabel = match ((int)$c->gender) {
                        1 => '男性',
                        2 => '女性',
                        3 => 'その他',
                        default => '-',
                    };

                    $categoryLabel = $c->category->content ?? '';

                    $telPlain = preg_replace('/\D+/', '', (string) $c->tel);

                    fputcsv($out, [
                        $c->id,
                        $c->last_name,
                        $c->first_name,
                        $genderLabel,
                        $c->email,
                        $telPlain,
                        $c->address,
                        $c->building,
                        $categoryLabel,
                        $c->detail,
                        optional($c->created_at)->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($out);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function buildFilteredQuery(Request $request)
    {
        $query = Contact::query()->with('category');

        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->where(function ($q) use ($kw) {
                $q->where('last_name', 'like', "%{$kw}%")
                    ->orWhere('first_name', 'like', "%{$kw}%")
                    ->orWhere('email', 'like', "%{$kw}%");
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        return $query;
    }

}
