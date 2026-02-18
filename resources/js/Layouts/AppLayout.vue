<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const settings = computed(() => page.props.settings);
const locale = computed(() => page.props.locale);
const isEn = computed(() => locale.value === 'en');

defineProps({
    /** @slot default */
    title: { type: String, default: '' },
});

const navLinks = [
    { name: 'Home', nameAr: 'الرئيسية', route: 'app.home' },
    { name: 'Properties', nameAr: 'العقارات', route: 'app.estates' },
    { name: 'Blog', nameAr: 'المدونة', route: 'app.posts' },
    { name: 'About', nameAr: 'من نحن', route: 'app.about' },
    { name: 'Contact Us', nameAr: 'اتصل بنا', route: 'app.contact' },
    { name: 'FAQ', nameAr: 'الأسئلة', route: 'app.faq' },
];
</script>

<template>
    <div id="app" :dir="isEn ? 'ltr' : 'rtl'">
        <!-- Header -->
        <header>
            <nav class="navbar">
                <div class="navbar-container">
                    <Link :href="route('app.home')" class="navbar-brand">
                        <img src="/images/logo1.png" alt="MmsEstate" class="nav-logo" />
                    </Link>

                    <!-- Contact Info -->
                    <div class="navbar-contact">
                        <a v-if="settings.phone" :href="`tel:${settings.phone}`" class="contact-link">
                            📞 {{ settings.phone }}
                        </a>
                        <a v-if="settings.whatsapp"
                            :href="`https://wa.me/${settings.whatsapp?.replace(/\s/g, '')}`"
                            target="_blank" class="contact-link whatsapp">
                            💬 {{ settings.whatsapp }}
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <ul class="nav-links">
                        <li v-for="link in navLinks" :key="link.route">
                            <Link :href="route(link.route)"
                                  :class="{ active: route().current(link.route) }">
                                {{ isEn ? link.name : link.nameAr }}
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('app.switch_lang')" class="lang-switch">
                                {{ isEn ? 'Ar' : 'En' }}
                            </Link>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Flash Messages -->
        <div v-if="$page.props.flash?.success" class="flash-success">
            {{ $page.props.flash.success }}
        </div>

        <!-- Main Content -->
        <main class="main-content">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="site-footer">
            <div class="footer-grid">
                <div class="footer-section footer-logo">
                    <Link :href="route('app.home')">
                        <img src="/images/logo1.png" alt="MmsEstate" class="logo-f" />
                    </Link>
                </div>

                <div class="footer-section">
                    <h3>{{ isEn ? 'Stay Connected' : 'ابق على تواصل' }}</h3>
                    <div class="social-links">
                        <a v-if="settings.facebook" :href="settings.facebook" target="_blank">Facebook</a>
                        <a v-if="settings.instagram" :href="settings.instagram" target="_blank">Instagram</a>
                        <a v-if="settings.twitter" :href="settings.twitter" target="_blank">Twitter</a>
                        <a v-if="settings.telegram" :href="settings.telegram" target="_blank">Telegram</a>
                        <a v-if="settings.linkedin" :href="settings.linkedin" target="_blank">LinkedIn</a>
                    </div>
                </div>

                <div class="footer-section">
                    <h3>{{ isEn ? 'Contact Us' : 'اتصل بنا' }}</h3>
                    <div class="footer-contact">
                        <a v-if="settings.phone" :href="`tel:${settings.phone}`">
                            📞 {{ settings.phone }}
                        </a>
                        <a v-if="settings.whatsapp"
                            :href="`https://wa.me/${settings.whatsapp?.replace(/\s/g, '')}`"
                            target="_blank">
                            💬 {{ settings.whatsapp }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-copyright">
                © {{ new Date().getFullYear() }} MmsEstate. All rights reserved.
            </div>
        </footer>
    </div>
</template>

<style scoped>
/* ─── Layout ─────────────────────────────────────────────────── */
#app {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    font-family: 'Poppins', sans-serif;
}

.main-content {
    flex: 1;
    padding: 2rem 1rem;
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
}

/* ─── Navbar ─────────────────────────────────────────────────── */
.navbar {
    background: #fff;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    padding: 0.75rem 1.5rem;
    position: sticky;
    top: 0;
    z-index: 100;
}

.navbar-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
    flex-wrap: wrap;
    gap: 1rem;
}

.nav-logo {
    height: 48px;
}

.navbar-contact {
    display: flex;
    gap: 1rem;
}

.contact-link {
    color: #555;
    text-decoration: none;
    font-size: 0.875rem;
}

.nav-links {
    display: flex;
    list-style: none;
    gap: 0.25rem;
    margin: 0;
    padding: 0;
    flex-wrap: wrap;
}

.nav-links a {
    color: #333;
    text-decoration: none;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s;
}

.nav-links a:hover,
.nav-links a.active {
    background: #2563eb;
    color: #fff;
}

.lang-switch {
    font-weight: 700;
    background: #f1f5f9 !important;
    color: #2563eb !important;
}

.lang-switch:hover {
    background: #2563eb !important;
    color: #fff !important;
}

/* ─── Flash ──────────────────────────────────────────────────── */
.flash-success {
    background: #10b981;
    color: #fff;
    padding: 0.75rem;
    text-align: center;
    font-weight: 500;
}

/* ─── Footer ─────────────────────────────────────────────────── */
.site-footer {
    background: #1e293b;
    color: #cbd5e1;
    padding: 2.5rem 1.5rem 1rem;
    margin-top: auto;
}

.footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.footer-section h3 {
    color: #fff;
    margin-bottom: 1rem;
    font-size: 1rem;
}

.social-links {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.social-links a,
.footer-contact a {
    color: #94a3b8;
    text-decoration: none;
    transition: color 0.2s;
}

.social-links a:hover,
.footer-contact a:hover {
    color: #fff;
}

.footer-contact {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.logo-f {
    height: 48px;
    filter: brightness(0) invert(1);
}

.footer-copyright {
    text-align: center;
    padding-top: 2rem;
    margin-top: 2rem;
    border-top: 1px solid #334155;
    font-size: 0.85rem;
    color: #64748b;
}
</style>
