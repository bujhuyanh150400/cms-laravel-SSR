<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body class="p-0 m-0 bg-stone-200 h-full relative">
<section class="flex w-full h-auto">
    <x-backend.section.navbar/>
    <div class="w-full h-auto">
        <x-backend.section.header>
            <x-slot name="title">
                @yield('title-header')
            </x-slot>
        </x-backend.section.header>
        <main
            class="bg-red-100 mx-4 mt-3 mb-12 px-6 py-4 rounded-lg border-t border-r drop-shadow-xl backdrop-blur-sm bg-white/90 z-10">
            @yield('main')
        </main>
    </div>
</section>
<section id="toast-section"></section>
</body>

</html>
<script type="module">
    const navMenu = {
        subNav: null,
        menus: $('.navmenu__left-item'),
        subMenus: $('.navmenu__left-sub-item'),
        toggleSubNav: function () {
            this.menus.each(function (index, menu) {
                if ($(menu).data('sub-key') !== undefined) {
                    let subKey = $(menu).data('sub-key');
                    $(menu).on('click', function () {
                        $(`.navmenu__left-sub-item[data-key="${subKey}"]`).slideToggle(100);
                    })
                }
            });
        },
        prepareSubNav: function () {
            this.subMenus.each(function (index, subMenu) {
                const subMenuActive = $(subMenu).find("li[data-active='true']");
                if (subMenuActive.length > 0) {
                    $(subMenu).show();
                } else {
                    $(subMenu).hide();
                }
            });

        },
        start: function () {
            this.prepareSubNav();
            this.toggleSubNav();
        }
    }
    navMenu.start();
    const app = {
        dropdown: {
            dropdownBtn: $('.dropdown__btn'),
            dropdownContent: $('.dropdown__content'),
            initDropdown: function () {
                $(document).on('click', function (e) {
                    if (!$(e.target).closest('.dropdown__container').length) {
                        this.dropdownContent.slideUp(100);
                    }
                }.bind(this));
                $('.dropdown__btn').on('click', this.toggleDropdown.bind(this));
            },
            toggleDropdown: function () {
                const thisDropdown = $(`${this.dropdownBtn.data('dropdown')}`);
                $('.dropdown__content').not(thisDropdown).hide();
                thisDropdown.slideToggle(100);
            }
        },
        showToast: (message, type = 'success', timeout = 5000) => {
            let icon;
            switch (type) {
                case 'error':
                    icon = '<i class="bi bi-exclamation-lg"></i>';
                    break;
                case 'warning':
                    break;
                    icon = '<i class="bi bi-cone"></i>';
                case 'success':
                    icon = '<i class="bi bi-check"></i>';
                    break;
                default:
                    type = 'warning';
                    icon = '<i class="bi bi-cone"></i>';
                    break;
            }
            let html =
                `<div class="toast-container" role="${type}"><div class="icon-holder">${icon}</div><div class="content">${message}</div><button type="button" class="btn-close"><i class="bi bi-x"></i></button></div>`;
            $('#toast-section').append(html);
            $('.toast-container').each(function (index, item) {
                $(item).on('click', function () {
                    $(this).hide(100);
                    setTimeout(() => {
                        $(this).remove()
                    }, 100)
                })
                setTimeout(() => {
                    $(this).fadeOut(3000);
                    setTimeout(() => {
                        $(this).remove()
                    }, 3000)
                }, timeout)
            })
        },

        start: function () {
            this.dropdown.initDropdown();
        }

    }
    app.start();


    @if (session('success'))
    app.showToast('{{ session('success') }}', 'success');
    @endif
    @if (session('error'))
    app.showToast('{{ session('error') }}', 'error');
    @endif
</script>
<script>
    function previewImage(event,previewAvatar) {
        const preview = $(previewAvatar);
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.empty();
                preview.css({
                    "background-image": `url("${e.target.result}")`
                })
                URL.revokeObjectURL(e.target.result);
            };
            reader.readAsDataURL(file);
        }
    }
</script>
