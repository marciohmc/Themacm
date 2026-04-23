    </main>

    <footer id="site-footer" class="py-20 px-6 border-t border-white/5 bg-[#0f172a]">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-16">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-500 rounded flex items-center justify-center text-white font-bold">CM</div>
                    <span class="text-white font-display font-bold text-xl uppercase italic">C&M Global</span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed max-w-xs">
                    Engenharia conectada ao amanhã. Soluções industriais inteligentes e conformidade técnica global.
                </p>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-6 uppercase tracking-widest text-xs">Contatos</h4>
                <ul class="space-y-4 text-slate-400 text-sm">
                    <li class="flex items-center gap-3">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                         (11) 94706-4454
                    </li>
                    <li class="flex items-center gap-3">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                         comercial@cmglobalservices.com.br
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold mb-6 uppercase tracking-widest text-xs">Localização</h4>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Av. das Nações, 1200 - Conj. 402<br/>
                    São Paulo - SP, Brasil.
                </p>
            </div>
        </div>
        
        <div class="container mx-auto mt-20 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4 text-slate-500 text-[10px] font-mono uppercase tracking-[0.2em]">
            <span>&copy; <?php echo date('Y'); ?> C&M Global Services. All rights reserved.</span>
            <div class="flex gap-4">
                <span class="border border-white/10 px-2 py-0.5 rounded">ISO 9001:2015</span>
                <span class="border border-white/10 px-2 py-0.5 rounded">Engenharia v2.1</span>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const header = document.getElementById('site-header');
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
            const menuIconOpen = document.getElementById('menu-icon-open');
            const menuIconClose = document.getElementById('menu-icon-close');

            // Scroll Logic
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('shadow-2xl');
                    header.classList.remove('h-24');
                    header.classList.add('h-16');
                    // Sync mobile drawer position if open
                    mobileMenuDrawer.classList.remove('top-24');
                    mobileMenuDrawer.classList.add('top-16');
                } else {
                    header.classList.remove('shadow-2xl');
                    header.classList.add('h-24');
                    header.classList.remove('h-16');
                    mobileMenuDrawer.classList.add('top-24');
                    mobileMenuDrawer.classList.remove('top-16');
                }
            });

            // Mobile Menu Logic
            let isMenuOpen = false;

            mobileMenuToggle.addEventListener('click', () => {
                isMenuOpen = !isMenuOpen;
                
                if (isMenuOpen) {
                    mobileMenuDrawer.classList.remove('translate-x-full');
                    menuIconOpen.classList.add('hidden');
                    menuIconClose.classList.remove('hidden');
                    document.body.style.overflow = 'hidden'; // Lock scroll
                } else {
                    mobileMenuDrawer.classList.add('translate-x-full');
                    menuIconOpen.classList.remove('hidden');
                    menuIconClose.classList.add('hidden');
                    document.body.style.overflow = ''; // Unlock scroll
                }
            });

            // Close menu on link click
            const mobileLinks = mobileMenuDrawer.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    isMenuOpen = false;
                    mobileMenuDrawer.classList.add('translate-x-full');
                    menuIconOpen.classList.remove('hidden');
                    menuIconClose.classList.add('hidden');
                    document.body.style.overflow = '';
                });
            });
        });
    </script>
</body>
</html>
