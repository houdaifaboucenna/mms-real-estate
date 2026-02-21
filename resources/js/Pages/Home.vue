<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const props = defineProps({
    types: Object,
    cities: Array,
    maxPrice: Number,
    minPrice: Number,
    posts: Array,
    postCount: Number,
    faqs: Array,
    faqCount: Number,
    estates: Array,
    estateCount: Number,
});
</script>

<template>

    <Head :title="isEn ? 'Home' : 'الرئيسية'" />

    <AppLayout>
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1>{{ isEn ? 'Find Your Dream Property' : 'ابحث عن عقارك المثالي' }}</h1>
                <p>{{ isEn ? 'Browse through our wide selection of properties' : 'تصفح مجموعتنا الواسعة من العقارات' }}
                </p>
                <Link :href="route('app.estates')" class="btn-primary">
                    {{ isEn ? 'View All Properties' : 'عرض جميع العقارات' }}
                    ({{ estateCount }})
                </Link>
            </div>
        </section>

        <!-- Estate Types -->
        <section class="section">
            <h2 class="section-title">{{ isEn ? 'Property Types' : 'أنواع العقارات' }}</h2>
            <div class="types-grid">
                <Link v-for="(label, key) in types" :key="key" :href="route('app.estate_filter', { type: key })"
                    class="type-card">
                    {{ label }}
                </Link>
            </div>
        </section>

        <!-- Featured Estates -->
        <section class="section" v-if="estates.length">
            <div class="section-header">
                <h2 class="section-title">{{ isEn ? 'Featured Properties' : 'عقارات مميزة' }}</h2>
                <a :href="route('app.estates')" class="see-all">
                    {{ isEn ? 'See All' : 'عرض الكل' }} →
                </a>
            </div>
            <div class="estates-grid">
                <Link v-for="estate in estates" :key="estate.id" :href="route('app.estate', estate.slug)"
                    class="estate-card">
                    <div class="estate-image">
                        <img v-if="estate.image" :src="`/storage/${JSON.parse(estate.image)?.[0]}`"
                            :alt="isEn ? estate.title : estate.title_ar" />
                        <div v-else class="estate-image-placeholder">🏠</div>
                        <span class="estate-type">{{ types[estate.type] || estate.type }}</span>
                    </div>
                    <div class="estate-info">
                        <h3>{{ isEn ? estate.title : estate.title_ar }}</h3>
                        <p class="estate-desc">{{ isEn ? estate.short : estate.short_ar }}</p>
                        <div class="estate-price" v-if="estate.min || estate.max">
                            {{ estate.min?.toLocaleString() }} - {{ estate.max?.toLocaleString() }}
                        </div>
                    </div>
                </Link>
            </div>
        </section>

        <!-- Latest Posts -->
        <section class="section" v-if="posts.length">
            <div class="section-header">
                <h2 class="section-title">{{ isEn ? 'Latest Articles' : 'أحدث المقالات' }}</h2>
                <Link :href="route('app.posts')" class="see-all">
                    {{ isEn ? 'See All' : 'عرض الكل' }} ({{ postCount }}) →
                </Link>
            </div>
            <div class="posts-grid">
                <Link v-for="post in posts" :key="post.id" :href="route('app.post', post.slug)" class="post-card">
                    <div class="post-image" v-if="post.image">
                        <img :src="`/storage/${post.image}`" :alt="isEn ? post.title : post.title_ar" />
                    </div>
                    <div class="post-info">
                        <h3>{{ isEn ? post.title : post.title_ar }}</h3>
                        <time>{{ new Date(post.created_at).toLocaleDateString() }}</time>
                    </div>
                </Link>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="section" v-if="faqs.length">
            <div class="section-header">
                <h2 class="section-title">{{ isEn ? 'FAQ' : 'الأسئلة الشائعة' }}</h2>
                <Link :href="route('app.faq')" class="see-all">
                    {{ isEn ? 'See All' : 'عرض الكل' }} ({{ faqCount }}) →
                </Link>
            </div>
            <div class="faq-list">
                <details v-for="faq in faqs" :key="faq.id" class="faq-item">
                    <summary>{{ isEn ? faq.question : faq.question_ar }}</summary>
                    <p>{{ isEn ? faq.answer : faq.answer_ar }}</p>
                </details>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>
/* ─── Hero ────────────────────────────────────────────────────── */
.hero {
    background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
    color: #fff;
    padding: 4rem 2rem;
    border-radius: 16px;
    text-align: center;
    margin-bottom: 3rem;
}

.hero h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.75rem;
}

.hero p {
    font-size: 1.15rem;
    opacity: 0.85;
    margin-bottom: 1.5rem;
}

.btn-primary {
    display: inline-block;
    background: #fff;
    color: #2563eb;
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: transform 0.2s, box-shadow 0.2s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

/* ─── Sections ────────────────────────────────────────────────── */
.section {
    margin-bottom: 3rem;
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.see-all {
    color: #2563eb;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
}

/* ─── Types Grid ──────────────────────────────────────────────── */
.types-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
}

.type-card {
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.25rem;
    text-align: center;
    font-weight: 600;
    color: #334155;
    text-decoration: none;
    transition: all 0.2s;
}

.type-card:hover {
    border-color: #2563eb;
    background: #eff6ff;
    color: #2563eb;
    transform: translateY(-2px);
}

/* ─── Estates Grid ────────────────────────────────────────────── */
.estates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.estate-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s, box-shadow 0.2s;
}

.estate-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
}

.estate-image {
    position: relative;
    height: 200px;
    background: #e2e8f0;
    overflow: hidden;
}

.estate-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.estate-image-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    font-size: 3rem;
}

.estate-type {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    background: #2563eb;
    color: #fff;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.estate-info {
    padding: 1.25rem;
}

.estate-info h3 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #1e293b;
}

.estate-desc {
    font-size: 0.85rem;
    color: #64748b;
    margin-bottom: 0.75rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.estate-price {
    font-weight: 700;
    color: #2563eb;
    font-size: 1rem;
}

/* ─── Posts Grid ───────────────────────────────────────────────── */
.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1.5rem;
}

.post-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s;
}

.post-card:hover {
    transform: translateY(-3px);
}

.post-image {
    height: 160px;
    overflow: hidden;
}

.post-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.post-info {
    padding: 1rem;
}

.post-info h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.post-info time {
    font-size: 0.8rem;
    color: #94a3b8;
}

/* ─── FAQ ──────────────────────────────────────────────────────── */
.faq-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.faq-item {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 1rem 1.25rem;
    cursor: pointer;
    transition: background 0.2s;
}

.faq-item:hover {
    background: #eff6ff;
}

.faq-item summary {
    font-weight: 600;
    color: #1e293b;
    list-style: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.faq-item summary::after {
    content: '+';
    font-size: 1.2rem;
    color: #2563eb;
}

.faq-item[open] summary::after {
    content: '−';
}

.faq-item p {
    margin-top: 0.75rem;
    color: #475569;
    line-height: 1.6;
}
</style>
