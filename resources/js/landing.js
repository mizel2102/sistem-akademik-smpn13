import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from '@studio-freight/lenis';
import SplitType from 'split-type';

gsap.registerPlugin(ScrollTrigger);

// Do not instantiate Lenis on the landing (home) page to avoid smoothing interference.
const isHome = window.location.pathname === '/' || window.location.pathname === '/home';
let lenis = null;
if (!isHome) {
    lenis = new Lenis({
        duration: 1.4,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        smoothWheel: true,
        smoothTouch: true,
        infinite: false,
    });

    function raf(time) {
        lenis.raf(time);
        requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);
}

function initHeroAnimation() {
    const hero = document.querySelector('#hero');
    if (!hero) return;

    const label = hero.querySelector('.hero-label');
    const title = hero.querySelector('.hero-title');
    const copy = hero.querySelector('.hero-copy');
    const actions = hero.querySelectorAll('.hero-action');
    const preview = hero.querySelector('.hero-panel');
    const shapes = hero.querySelectorAll('.hero-shape');

    const split = new SplitType(title, { types: 'lines, words, chars' });

    gsap.fromTo(label, { opacity: 0, y: 24 }, { opacity: 1, y: 0, duration: 1, ease: 'power4.out' });
    gsap.fromTo(split.chars, { opacity: 0, y: 48 }, {
        opacity: 1,
        y: 0,
        duration: 1.2,
        ease: 'power4.out',
        stagger: 0.03,
        delay: 0.2,
    });

    gsap.fromTo(copy, { opacity: 0, y: 24 }, { opacity: 1, y: 0, duration: 1, delay: 0.8, ease: 'power4.out' });
    gsap.fromTo(actions, { opacity: 0, y: 24, scale: 0.95 }, { opacity: 1, y: 0, scale: 1, duration: 0.8, delay: 1.1, stagger: 0.1, ease: 'power4.out' });
    gsap.fromTo(preview, { opacity: 0, y: 40, scale: 0.98 }, { opacity: 1, y: 0, scale: 1, duration: 1.2, delay: 1.2, ease: 'power4.out' });
    gsap.fromTo(shapes, { opacity: 0, y: 80, rotation: 15 }, { opacity: 1, y: 0, rotation: 0, duration: 1.5, delay: 1, stagger: 0.1, ease: 'power4.out' });
}

function animateSections() {
    document.querySelectorAll('[data-animate]').forEach((section) => {
        gsap.fromTo(section,
            { opacity: 0, y: 70 },
            {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power4.out',
                scrollTrigger: {
                    trigger: section,
                    start: 'top 80%',
                    end: 'bottom 30%',
                    toggleActions: 'play none none reverse',
                },
            }
        );

        section.querySelectorAll('.reveal-item').forEach((item, index) => {
            gsap.fromTo(item,
                { opacity: 0, y: 40 },
                {
                    opacity: 1,
                    y: 0,
                    duration: 0.9,
                    delay: 0.1 * index,
                    ease: 'power4.out',
                    scrollTrigger: {
                        trigger: section,
                        start: 'top 85%',
                        end: 'bottom 30%',
                        toggleActions: 'play none none reverse',
                    },
                }
            );
        });
    });
}

function initStatistics() {
    const stats = document.querySelectorAll('[data-stat]');
    stats.forEach((stat) => {
        const target = +stat.dataset.stat;
        if (!target) return;
        let current = 0;
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                const duration = 1.4;
                gsap.to({ value: 0 }, {
                    value: target,
                    duration,
                    ease: 'power1.out',
                    onUpdate() {
                        stat.textContent = Math.floor(this.targets()[0].value).toLocaleString();
                    },
                });
                obs.disconnect();
            });
        }, { threshold: 0.5 });
        observer.observe(stat);
    });
}

function initScrollEffects() {
    const hero = document.querySelector('#hero');
    const preview = hero?.querySelector('.hero-panel');
    if (!hero || !preview) return;

    window.addEventListener('scroll', () => {
        const progress = window.scrollY / window.innerHeight;
        preview.style.transform = `translateY(${Math.min(progress * 20, 15)}px) rotate(${Math.min(progress * 5, 3)}deg)`;
    });
}

// Navigation smooth scroll dengan animasi
function initNavigation() {
    const navLinks = document.querySelectorAll('a[href^="#"]');
    
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            const hash = href.slice(1);
            
            if (!hash) return;
            
            e.preventDefault();
            
            const section = document.getElementById(hash);
            if (!section) return;
            
            // Close mobile menu jika terbuka
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                if (mobileMenuBtn) {
                    mobileMenuBtn.setAttribute('aria-expanded', 'false');
                }
            }
            
            // Instant native scroll (no delay) and update URL hash
            section.scrollIntoView({ behavior: 'auto', block: 'start' });
            try { history.replaceState(null, '', '#' + hash); } catch (e) { window.location.hash = '#' + hash; }
            
            // Quick click feedback (no delayed reset)
            link.style.transition = 'transform 0.12s ease-out';
            link.style.transform = 'scale(1.04)';
            requestAnimationFrame(() => {
                setTimeout(() => {
                    link.style.transform = '';
                }, 120);
            });
        });
    });
}

// Track active section dan highlight navbar
function initActiveSection() {
    const sections = document.querySelectorAll('[id]');
    const navLinks = document.querySelectorAll('nav a[href*="#"]');
    
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const id = entry.target.id;
                    
                    // Remove active class dari semua links
                    navLinks.forEach(link => {
                        link.classList.remove('text-white', 'font-bold');
                        link.classList.add('text-slate-100');
                    });
                    
                    // Add active class ke link yang sesuai
                    const activeLink = document.querySelector(`nav a[href*="#${id}"]`);
                    if (activeLink) {
                        activeLink.classList.remove('text-slate-100');
                        activeLink.classList.add('text-white', 'font-bold');
                        
                        // Subtle underline animation
                        gsap.to(activeLink, {
                            backgroundImage: 'linear-gradient(to right, rgba(255,255,255,0.3), transparent)',
                            backgroundPosition: '0% 100%',
                            backgroundSize: '200% 1px',
                            backgroundRepeat: 'no-repeat',
                            duration: 0.4,
                            ease: 'power2.out',
                        });
                    }
                }
            });
        },
        {
            threshold: 0.3,
        }
    );
    
    sections.forEach(section => {
        if (section.id) observer.observe(section);
    });
}

function init() {
    initHeroAnimation();
    animateSections();
    initStatistics();
    initScrollEffects();
    initNavigation();
    initActiveSection();
}

window.addEventListener('DOMContentLoaded', init);
