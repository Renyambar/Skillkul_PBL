{{-- Shared Footer Component --}}
<footer class="bg-white dark:bg-brand-darksurface border-t border-gray-100 dark:border-brand-darkborder py-10 px-6 md:px-12 mt-auto transition-colors duration-300">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex flex-col items-center md:items-start gap-2">
            <a href="/" class="text-xl font-extrabold text-brand-dark dark:text-white tracking-tight flex items-center gap-2">
                <img src="{{ asset('images/logo-3.png') }}" class="w-8 h-8 object-contain rounded-lg shadow-md" alt="SkillKul Logo">
                Skill<span class="text-brand-primary dark:text-indigo-400">Kul</span>
            </a>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">&copy; {{ date('Y') }} SkillKul. Rekening Bersama (Escrow) Aman Terjamin.</p>
        </div>
        <div class="flex flex-wrap gap-6 text-xs font-bold text-gray-500 dark:text-gray-400">
            <a href="#" class="hover:text-brand-primary dark:hover:text-indigo-400 transition-colors">Ketentuan Layanan</a>
            <a href="#" class="hover:text-brand-primary dark:hover:text-indigo-400 transition-colors">FAQ</a>
            <a href="/tentang" class="hover:text-brand-primary dark:hover:text-indigo-400 transition-colors">Tentang Kami</a>
            <a href="/keamanan" class="hover:text-brand-primary dark:hover:text-indigo-400 transition-colors">Pusat Keamanan</a>
        </div>
    </div>
</footer>
