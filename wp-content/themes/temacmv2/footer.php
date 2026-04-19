    </main>

    <footer id="site-footer" class="h-20 px-10 flex items-center justify-between border-t border-border-color bg-slate-dark text-text-secondary text-[12px]">
        <div>
            &copy; <?php echo date('Y'); ?> C&M Global Services - Todos os direitos reservados.
        </div>
        <div class="hidden md:flex items-center gap-8">
            <div class="flex gap-6">
                <span>Av. das Nações, 1200 - SP</span>
                <span>comercial@cmglobalservices.com.br</span>
            </div>
            <span class="font-bold border border-text-secondary px-1.5 py-0.5 rounded-sm text-[10px] text-text-secondary">ISO 9001:2015</span>
        </div>
    </footer>

    <?php wp_footer(); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const header = document.getElementById('site-header');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('shadow-2xl');
                    header.classList.remove('h-20');
                    header.classList.add('h-16');
                } else {
                    header.classList.remove('shadow-2xl');
                    header.classList.add('h-20');
                    header.classList.remove('h-16');
                }
            });
        });
    </script>
</body>
</html>
