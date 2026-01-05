@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
  <main class="container">
    <h1 class="page-title">Confirm</h1>

    <div class="confirm-wrap">
      <table class="confirm-table">
        <tr>
          <th>お名前</th>
          <td>{{ $contact['first_name'] }} {{ $contact['last_name'] }}</td>
        </tr>
        <tr>
          <th>性別</th>
          <td>
            @if ($contact['gender'] == 1)
              男性
            @elseif ($contact['gender'] == 2)
              女性
            @elseif ($contact['gender'] == 3)
              その他
            @endif
          </td>
        </tr>
        <tr>
          <th>メールアドレス</th>
          <td>{{ $contact['email'] }}</td>
        </tr>
        <tr>
          <th>電話番号</th>
          <td>{{ $contact['tel'] }}</td>
        </tr>
        <tr>
          <th>住所</th>
          <td>{{ $contact['address'] }}</td>
        </tr>
        <tr>
          <th>建物名</th>
          <td>{{ $contact['building'] }}</td>
        </tr>
        <tr>
          <th>お問い合わせの種類</th>
          <td>
            {{ $category->content }}
          </td>
        </tr>
        <tr>
          <th>お問い合わせ内容</th>
          <td class="confirm-content">{{ $contact['detail'] }}</td>
        </tr>
      </table>

      <div class="confirm-actions">
        <form method="POST" action="/thanks">
          @csrf
          @foreach ($contact as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
          @endforeach
          <button type="submit" class="btn btn-primary">送信</button>
        </form>

        {{-- 修正（入力画面に戻る） --}}
        <form method="POST" action="/">
          @csrf
          @foreach ($contact as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
          @endforeach
          <button type="submit" class="btn btn-link">修正</button>
        </form>
      </div>
    </div>
  </main>
@endsection