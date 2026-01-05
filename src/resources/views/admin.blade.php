@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('header')
  <div class="header-actions">
    @auth
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="header-btn">logout</button>
      </form>
    @else
      <a href="{{ route('login') }}" class="header-btn">login</a>
    @endauth
  </div>
@endsection

@section('content')
  <main class="admin">

    <h2 class="admin__title">Admin</h2>

    <section class="admin__search">
      <form method="GET" action="{{ route('admin.search') }}" class="admin-search">
        <div class="admin-search__row">

          {{-- 「名前やメールアドレス」 --}}
          <input
            type="text"
            name="keyword"
            value="{{ request('keyword') }}"
            placeholder="名前やメールアドレスを入力してください"
            class="admin-search__input"
          >

          {{-- 性別 --}}
          <select name="gender" class="admin-search__select">
            <option value="">性別</option>
            <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
            <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
            <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
          </select>

          {{-- お問い合わせの種類 --}}
          <select name="category_id" class="admin-search__select">
            <option value="">お問い合わせの種類</option>

            @foreach($categories as $id => $label)
                <option value="{{ $id }}"
                    {{ (string)request('category_id') === (string)$id ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
          </select>

          {{-- 年/月/日 --}}
          <input
            type="date"
            name="date"
            value="{{ request('date') }}"
            class="admin-search__date"
          >

          {{-- 検索 --}}
          <button type="submit" class="admin-search__btn admin-search__btn--search">
            検索
          </button>

          {{-- リセット --}}
          <a href="{{ route('admin.reset') }}" class="admin-search__btn admin-search__btn--reset">
            リセット
          </a>

        </div>
      </form>
    </section>

    <section class="admin__topbar">
      <div class="admin-topbar__left">
        <a href="{{ route('admin.export', request()->query()) }}" class="admin-export">
          エクスポート
        </a>
      </div>

      <div class="admin-topbar__right">
        {{ $contacts->appends(request()->query())->links() }}
      </div>
    </section>

    {{-- 一覧テーブル --}}
    <section class="admin__table">
      <table class="admin-table">
        <thead>
          <tr>
            <th>お名前</th>
            <th>性別</th>
            <th>メールアドレス</th>
            <th>お問い合わせの種類</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @foreach($contacts as $contact)
            <tr>
              <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>

              <td>{{ $contact->gender_label }}</td>

              <td>{{ $contact->email }}</td>

              <td>{{ $contact->category->content ?? $contact->category_id }}</td>

                <td class="admin-table__actions">
                    <button
                        type="button"
                        class="admin-btn admin-btn--detail js-open-modal"
                        data-id="{{ $contact->id }}"
                        data-name="{{ $contact->name }}"
                        data-gender="{{ $contact->gender_label ?? ($contact->gender == 1 ? '男性' : '女性') }}"
                        data-email="{{ $contact->email }}"
                        data-tel="{{ $contact->tel_plain }}"
                        data-address="{{ $contact->address }}"
                        data-building="{{ $contact->building }}"
                        data-category="{{ $contact->category->content ?? '' }}"
                        data-detail="{{ $contact->detail }}"
                    >
                    詳細
                    </button>
                </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
    {{-- Modal --}}
<div class="modal" id="contactModal" aria-hidden="true">
  <div class="modal__backdrop js-close-modal"></div>

  <div class="modal__panel" role="dialog" aria-modal="true">
    <button type="button" class="modal__close js-close-modal" aria-label="閉じる">×</button>

    <div class="modal__body">
        <dl class="modal__dl">
            <dt>お名前</dt>           <dd id="mName"></dd>
            <dt>性別</dt>             <dd id="mGender"></dd>
            <dt>メールアドレス</dt>   <dd id="mEmail"></dd>
            <dt>電話番号</dt>         <dd id="mTel"></dd>
            <dt>住所</dt>             <dd id="mAddress"></dd>
            <dt>建物名</dt>           <dd id="mBuilding"></dd>
            <dt>お問い合わせの種類</dt><dd id="mCategory"></dd>
            <dt>お問い合わせ内容</dt> <dd><pre id="mDetail" class="modal__pre"></pre></dd>
        </dl>
        <form method="POST" id="deleteForm" class="modal__actions">
            @csrf
            @method('DELETE')
            <button type="submit" class="modal__delete">削除</button>
        </form>
    </div>
  </div>
</div>

<script>
  const modal = document.getElementById('contactModal');

  const setText = (id, value) => {
    const el = document.getElementById(id);
    if (!el) return;
    el.textContent = value ?? '';
  };

  const openModal = (btn) => {
    setText('mName', btn.dataset.name);
    setText('mGender', btn.dataset.gender);
    setText('mEmail', btn.dataset.email);
    setText('mTel', btn.dataset.tel);
    setText('mAddress', btn.dataset.address);
    setText('mBuilding', btn.dataset.building);
    setText('mCategory', btn.dataset.category);
    setText('mDetail', btn.dataset.detail);

    const id = btn.dataset.id;
    const deleteForm = document.getElementById('deleteForm');
    if (deleteForm) {
      deleteForm.action = `/delete/${id}`;
    }

    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  };

  const closeModal = () => {
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  };

  document.addEventListener('click', (e) => {
    const openBtn = e.target.closest('.js-open-modal');
    if (openBtn) openModal(openBtn);

    if (e.target.closest('.js-close-modal')) closeModal();
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
  });
</script>

  </main>
@endsection