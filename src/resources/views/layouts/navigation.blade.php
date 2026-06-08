<nav x-data="{ 
        open: false,
        isDarkMode: localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
        toggleDarkMode() {
            this.isDarkMode = !this.isDarkMode;
            if (this.isDarkMode) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }
        }
    }" 
    class="bg-white/90 dark:bg-brand-darksurface/90 backdrop-blur-lg border-b border-gray-100 dark:border-brand-darkborder sticky top-0 z-50 transition-colors duration-300">
    
    @php
        $navUser = Auth::user();
        $navPhoto = $navUser && $navUser->profile_photo_path
            ? asset('storage/' . $navUser->profile_photo_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($navUser?->name ?? 'User') . '&background=140c61&color=fff';
    @endphp

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-extrabold text-brand-dark dark:text-white tracking-tight flex items-center gap-2">
                        <div class="w-10 h-10 bg-brand-primary text-white rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <span class="hidden sm:inline">Skill<span class="text-brand-primary dark:text-indigo-400">Kul</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-12 sm:flex">
                    @if($navUser && in_array($navUser->role, ['client', 'admin']))
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-600 dark:text-gray-300 hover:text-brand-primary dark:hover:text-indigo-400 font-semibold tracking-wide">
                        Dasbor Klien
                    </x-nav-link>

                    <x-nav-link :href="route('katalog')" :active="request()->routeIs('katalog')" class="text-gray-600 dark:text-gray-300 hover:text-brand-primary dark:hover:text-indigo-400 font-semibold tracking-wide">
                        Katalog Jasa
                    </x-nav-link>
                    @endif

                    @if($navUser && in_array($navUser->role, ['freelancer', 'admin']))
                    <x-nav-link :href="route('freelancer.dasbor')" :active="request()->routeIs('freelancer.dasbor')" class="text-gray-600 dark:text-gray-300 hover:text-brand-primary dark:hover:text-indigo-400 font-semibold tracking-wide">
                        Dasbor Pekerja Lepas
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings & Dark Mode -->
            <div class="hidden sm:flex sm:items-center sm:gap-4">
                
                <!-- Dark Mode Toggle -->
                <button @click="toggleDarkMode()" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none rounded-full text-sm p-2.5 transition-colors">
                    <!-- Sun icon -->
                    <svg x-show="isDarkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" style="display: none;">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4.22 1.32a1 1 0 011.415 0l.708.708a1 1 0 01-1.414 1.415l-.708-.708a1 1 0 010-1.415zM16 10a1 1 0 01-1-1h-1a1 1 0 110-2h1a1 1 0 011 1zM14.22 17.68a1 1 0 010-1.415l.708-.708a1 1 0 011.414 1.415l-.708.708a1 1 0 01-1.415 0zM10 16a1 1 0 01-1-1v-1a1 1 0 112 0v1a1 1 0 01-1 1zm-4.22-1.32a1 1 0 01-1.415 0l-.708-.708a1 1 0 011.414-1.415l.708.708a1 1 0 010 1.415zM4 10a1 1 0 011 1h1a1 1 0 110 2H5a1 1 0 01-1-1zM5.78 2.32a1 1 0 010 1.415l-.708.708a1 1 0 01-1.414-1.415l.708-.708a1 1 0 011.415 0zM10 5a5 5 0 100 10 5 5 0 000-10z"></path>
                    </svg>
                    <!-- Moon icon -->
                    <svg x-show="!isDarkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </button>

                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 p-1.5 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-full transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                            <img src="{{ $navPhoto }}" alt="Foto profil {{ $navUser?->name ?? 'User' }}"
                                class="h-8 w-8 rounded-full object-cover">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 pr-2">{{ explode(' ', Auth::user()->name)[0] }}</span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                            <p class="text-sm text-gray-900 dark:text-white font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')" class="dark:text-gray-300 dark:hover:bg-gray-700">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-brand-primary dark:hover:text-indigo-400 px-3 py-2 rounded-lg transition-colors">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-brand-primary text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-brand-dark dark:hover:bg-indigo-900 transition-colors shadow-sm shadow-indigo-500/30">Daftar</a>
                    @endif
                </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden gap-2">
                <button @click="toggleDarkMode()" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none rounded-full p-2 transition-colors">
                    <svg x-show="isDarkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" style="display: none;"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4.22 1.32a1 1 0 011.415 0l.708.708a1 1 0 01-1.414 1.415l-.708-.708a1 1 0 010-1.415zM16 10a1 1 0 01-1-1h-1a1 1 0 110-2h1a1 1 0 011 1zM14.22 17.68a1 1 0 010-1.415l.708-.708a1 1 0 011.414 1.415l-.708.708a1 1 0 01-1.415 0zM10 16a1 1 0 01-1-1v-1a1 1 0 112 0v1a1 1 0 01-1 1zm-4.22-1.32a1 1 0 01-1.415 0l-.708-.708a1 1 0 011.414-1.415l.708.708a1 1 0 010 1.415zM4 10a1 1 0 011 1h1a1 1 0 110 2H5a1 1 0 01-1-1zM5.78 2.32a1 1 0 010 1.415l-.708.708a1 1 0 01-1.414-1.415l.708-.708a1 1 0 011.415 0zM10 5a5 5 0 100 10 5 5 0 000-10z"></path></svg>
                    <svg x-show="!isDarkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                </button>
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white dark:bg-brand-darksurface border-t border-gray-100 dark:border-gray-800">
        <div class="pt-2 pb-3 space-y-1">
            @if($navUser && in_array($navUser->role, ['client', 'admin']))
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800">
                Dasbor Klien
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('katalog')" :active="request()->routeIs('katalog')" class="dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800">
                Katalog Jasa
            </x-responsive-nav-link>
            @endif

            @if($navUser && in_array($navUser->role, ['freelancer', 'admin']))
            <x-responsive-nav-link :href="route('freelancer.dasbor')" :active="request()->routeIs('freelancer.dasbor')" class="dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800">
                Dasbor Pekerja Lepas
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            @auth
            <div class="px-4">
                <div class="flex items-center gap-3">
                    <img src="{{ $navPhoto }}" alt="Foto profil {{ $navUser?->name ?? 'User' }}" class="h-10 w-10 rounded-full object-cover border border-gray-200 dark:border-gray-600">
                    <div>
                        <div class="font-bold text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-4 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @else
            <div class="px-4 space-y-1 pb-3">
                <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 font-bold mb-2">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 bg-brand-primary text-white rounded-xl font-bold">Register</a>
                @endif
            </div>
            @endauth
        </div>
    </div>
</nav>