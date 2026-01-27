<?php 
    require_once 'base.php';
?>


<title>EquityLearnKU - คลังทรัพยากร</title>
</head>

<body class="bg-gray-100">
    <div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto ">
        <!-- Navigation -->
        <?php include_once '../component/sidebar.php' ?>

        <!-- Main Content -->
        <div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <div class="flex flex-col">
                <div class="flex justify-between mb-4 md:mx-4">
                    <h1 class="text-xl text-[#433878]">คลังทรัพยากร</h1>
                    <p class="text-gray-700"><a href="./"
                            class="text-gray-400  hover:font-semibold hover:text-[#433878]">Home</a>
                        > Storage</p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-xl text-[#433878]">โพสต์ทั้งหมด</h2>
                        <div class="flex items-center gap-2">
                            <button id="view-grid" type="button" title="มุมมองการ์ด" aria-label="มุมมองการ์ด" class="px-3 py-1.5 text-sm rounded bg-purple-700 text-white hover:bg-purple-800 inline-flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                    <path d="M3 3.75A.75.75 0 0 1 3.75 3h6A.75.75 0 0 1 10.5 3.75v6a.75.75 0 0 1-.75.75h-6A.75.75 0 0 1 3 9.75v-6ZM13.5 3.75A.75.75 0 0 1 14.25 3h6a.75.75 0 0 1 .75.75v6a.75.75 0 0 1-.75.75h-6a.75.75 0 0 1-.75-.75v-6ZM3 14.25a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 .75.75v6a.75.75 0 0 1-.75.75h-6A.75.75 0 0 1 3 20.25v-6ZM13.5 14.25a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 .75.75v6a.75.75 0 0 1-.75.75h-6a.75.75 0 0 1-.75-.75v-6Z"/>
                                </svg>
                            </button>
                            <button id="view-list" type="button" title="มุมมองรายการ" aria-label="มุมมองรายการ" class="px-3 py-1.5 text-sm rounded bg-gray-100 text-gray-700 hover:bg-gray-200 inline-flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 17.25Z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-3 md:items-center mb-3">
                        <div class="flex-1">
                            <input id="posts-search" type="search" placeholder="ค้นหาโพสต์ (ชื่อ/หมวดหมู่)..." class="w-full border border-gray-200 rounded px-3 py-2 focus:ring-purple-500 focus:border-purple-500" />
                        </div>
                        <div class="flex gap-2 items-center">
                            <select id="category" class="border border-gray-200 rounded px-3 py-2 bg-white">
                                <option value="all">ทุกหมวดหมู่</option>
                            </select>
                            <button id="clear" type="button" class="px-3 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">ล้าง</button>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 mb-2"><span id="posts-count">0</span> รายการ</div>
                    <hr class="border-0.5 border-gray-100 my-4 -mx-4">
                    <!-- content -->
                    <div id="posts-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        
                    </div>
                </div>
            </div>
            <!--  -->
            
        </div>
    </div>
</body>

<script>
(() => {
    const list = document.getElementById('posts-list');
    const countEl = document.getElementById('posts-count');
    const inputSearch = document.getElementById('posts-search');
    const selectCategory = document.getElementById('category');
    const btnClear = document.getElementById('clear');
    const btnGrid = document.getElementById('view-grid');
    const btnList = document.getElementById('view-list');

    if (!list) return;

    const state = {
        view: 'grid',
        query: '',
        category: 'all',
        posts: [],
    };

    const getQueryValue = () => {
        const raw = String(inputSearch?.value ?? state.query ?? '');
        return raw.replace(/\s+/g, ' ').trim().toLowerCase();
    };

    const setCount = (n) => {
        if (countEl) countEl.textContent = String(n || 0);
    };

    const safeText = (v) => (v === undefined || v === null || String(v).trim() === '' ? '-' : String(v));
    const safeDate = (v) => {
        const s = safeText(v);
        if (s === '-') return '-';
        return s.length >= 10 ? s.substring(0, 10) : s;
    };
    const safeUrl = (v) => {
        const s = String(v || '').trim();
        if (!s) return '../image/no-thumbnail.png';
        // allow http(s) and relative paths
        if (s.startsWith('http://') || s.startsWith('https://') || s.startsWith('../') || s.startsWith('./') || s.startsWith('/')) return s;
        return '../image/no-thumbnail.png';
    };

    const applyView = (view) => {
        state.view = view;
        if (view === 'grid') {
            list.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4';
            btnGrid?.classList.add('bg-purple-700', 'text-white');
            btnGrid?.classList.remove('bg-gray-100', 'text-gray-700');
            btnList?.classList.add('bg-gray-100', 'text-gray-700');
            btnList?.classList.remove('bg-purple-700', 'text-white');
        } else {
            list.className = 'flex flex-col gap-3';
            btnList?.classList.add('bg-purple-700', 'text-white');
            btnList?.classList.remove('bg-gray-100', 'text-gray-700');
            btnGrid?.classList.add('bg-gray-100', 'text-gray-700');
            btnGrid?.classList.remove('bg-purple-700', 'text-white');
        }
    };

    const setView = (view) => {
        applyView(view);
        render();
    };

    const buildCategoryOptions = (posts) => {
        if (!selectCategory) return;
        const categories = new Set();
        (posts || []).forEach((p) => {
            const c = String(p?.category || '').trim();
            if (c) categories.add(c);
        });

        const current = state.category;
        selectCategory.innerHTML = '';
        const optAll = document.createElement('option');
        optAll.value = 'all';
        optAll.textContent = 'ทุกหมวดหมู่';
        selectCategory.appendChild(optAll);

        Array.from(categories).sort((a, b) => a.localeCompare(b)).forEach((c) => {
            const opt = document.createElement('option');
            opt.value = c;
            opt.textContent = c;
            selectCategory.appendChild(opt);
        });

        // restore selection if possible
        if (current) selectCategory.value = current;
    };

    const applyFilters = () => {
        const q = getQueryValue();
        const cat = state.category;
        return (state.posts || []).filter((p) => {
            if (cat !== 'all' && String(p?.category || '') !== cat) return false;
            if (!q) return true;
            const title = String(p?.title || '').toLowerCase();
            const category = String(p?.category || '').toLowerCase();
            return title.includes(q) || category.includes(q);
        });
    };

    const createCard = (item) => {
        const id = item?.id;
        const card = document.createElement('div');
        card.className = 'bg-white rounded-lg shadow-lg flex flex-col overflow-hidden border border-gray-100 hover:shadow-xl transition';

        const link = document.createElement('a');
        link.href = `post?id=${encodeURIComponent(String(id ?? ''))}`;

        const img = document.createElement('img');
        img.src = safeUrl(item?.thumbnail);
        img.alt = 'thumbnail';
        img.className = 'w-full h-60 object-cover bg-gray-100';
        link.appendChild(img);
        card.appendChild(link);

        const body = document.createElement('div');
        body.className = 'p-4 flex-1 flex flex-col justify-between';

        const title = document.createElement('h3');
        title.className = 'font-semibold text-[#433878] text-lg mb-1';
        const titleLink = document.createElement('a');
        titleLink.href = `post?id=${encodeURIComponent(String(id ?? ''))}`;
        titleLink.className = 'hover:underline';
        titleLink.textContent = safeText(item?.title);
        title.appendChild(titleLink);

        const category = document.createElement('p');
        category.className = 'text-gray-500 text-sm mb-2';
        category.textContent = safeText(item?.category);

        const date = document.createElement('p');
        date.className = 'text-gray-400 text-xs';
        date.textContent = safeDate(item?.uploaded_at);

        body.appendChild(title);
        body.appendChild(category);
        body.appendChild(date);
        card.appendChild(body);
        return card;
    };

    const createRow = (item) => {
        const id = item?.id;
        const row = document.createElement('a');
        row.href = `post?id=${encodeURIComponent(String(id ?? ''))}`;
        row.className = 'bg-white rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition p-3 flex gap-3 items-center';

        const img = document.createElement('img');
        img.src = safeUrl(item?.thumbnail);
        img.alt = 'thumbnail';
        img.className = 'w-20 h-14 object-cover bg-gray-100 rounded';

        const meta = document.createElement('div');
        meta.className = 'min-w-0 flex-1';

        const title = document.createElement('div');
        title.className = 'font-semibold text-[#433878] truncate';
        title.textContent = safeText(item?.title);

        const sub = document.createElement('div');
        sub.className = 'text-xs text-gray-500 truncate';
        sub.textContent = `${safeText(item?.category)} • ${safeDate(item?.uploaded_at)}`;

        meta.appendChild(title);
        meta.appendChild(sub);

        const chevron = document.createElement('div');
        chevron.className = 'text-gray-300 text-xl';
        chevron.textContent = '›';

        row.appendChild(img);
        row.appendChild(meta);
        row.appendChild(chevron);
        return row;
    };

    const render = () => {
        const filtered = applyFilters();
        setCount(filtered.length);
        list.innerHTML = '';

        if (filtered.length === 0) {
            const empty = document.createElement('div');
            empty.className = 'p-4 text-gray-400';
            empty.textContent = 'ไม่พบข้อมูล';
            list.appendChild(empty);
            return;
        }

        filtered.forEach((item) => {
            list.appendChild(state.view === 'grid' ? createCard(item) : createRow(item));
        });
    };

    const showLoading = () => {
        list.innerHTML = '';
        const loading = document.createElement('div');
        loading.className = 'flex justify-center items-center w-full py-12';
        loading.innerHTML = '<img src="../image/loading.gif" alt="loading" class="w-16 h-16">';
        list.appendChild(loading);
    };

    // Ensure the view classes are applied without replacing the loading state.
    applyView('grid');
    showLoading();

    fetch('../backend/api/get_posts.php')
        .then((res) => res.json())
        .then((data) => {
            if (data?.success && Array.isArray(data.data)) {
                state.posts = data.data;
                buildCategoryOptions(state.posts);
                state.query = String(inputSearch?.value ?? state.query ?? '');
                render();
            } else {
                state.posts = [];
                buildCategoryOptions([]);
                render();
            }
        })
        .catch(() => {
            state.posts = [];
            buildCategoryOptions([]);
            render();
        });

    const onSearchChange = () => {
        state.query = String(inputSearch?.value ?? '');
        render();
    };
    inputSearch?.addEventListener('input', onSearchChange);
    inputSearch?.addEventListener('keyup', onSearchChange);
    inputSearch?.addEventListener('change', onSearchChange);
    inputSearch?.addEventListener('search', onSearchChange);

    selectCategory?.addEventListener('change', () => {
        state.category = selectCategory.value || 'all';
        render();
    });

    btnClear?.addEventListener('click', () => {
        
        state.query = '';
        state.category = 'all';
        if (inputSearch) inputSearch.value = '';
        if (selectCategory) selectCategory.value = 'all';
        render();
    });

    btnGrid?.addEventListener('click', () => setView('grid'));
    btnList?.addEventListener('click', () => setView('list'));
})();
</script>

</html>