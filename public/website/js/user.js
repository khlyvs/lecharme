// Performance optimized - Single DOM query and event delegation
(function() {
    'use strict';

    // Cache DOM elements once
    const userPage = document.getElementById('user__page');
    if (!userPage) return;

    const userNav = document.getElementById('user__nav');
    const tabContents = document.querySelectorAll('.user__tab-content');
    const profileForm = document.getElementById('user__profile-form');
    const submitBtn = document.getElementById('user__save-btn');
    const cancelBtn = document.getElementById('user__cancel-btn');

    // Cache text content to avoid repeated DOM queries
    let submitBtnOriginalText = submitBtn?.querySelector('span')?.textContent || '';

    // Tab switching with event delegation (single listener instead of multiple)
    if (userNav) {
        userNav.addEventListener('click', (e) => {
            const navItem = e.target.closest('.user__nav-item');
            if (!navItem) return;

            const tabName = navItem.getAttribute('data-tab');
            if (!tabName) return;

            // Handle logout separately - don't change active state until confirmed
            if (tabName === 'logout') {
                Swal.fire({
                    title: 'Çıkış yapmak istediğinize emin misiniz?',
                    text: 'Hesabınızdan çıkış yapacaksınız',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#1a1a1a',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Evet, Çıkış Yap',
                    cancelButtonText: 'İptal',
                    reverseButtons: true
                }).then((result) => {
                     if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Çıkış yapılıyor...',
                            text: 'Güle güle!',
                            icon: 'success',
                            timer: 1200,
                            showConfirmButton: false
                        }).then(() => {
                            document.getElementById('logoutForm').submit();
                        });
                    }
                });
                // If cancelled, don't change anything - just return
                return;
            }

            // Save previous active state before changing
            const previousActiveNav = userNav.querySelector('.user__nav-item.active');
            let previousActiveTab = null;
            tabContents.forEach(tab => {
                if (tab.classList.contains('active')) {
                    previousActiveTab = tab;
                    tab.classList.remove('active');
                }
            });

            // Remove active class from previous nav item
            if (previousActiveNav) {
                previousActiveNav.classList.remove('active');
            }

            // Add active class to clicked nav item
            navItem.classList.add('active');

            // Show target tab
            const targetTab = document.getElementById(`user__tab-${tabName}`);
            if (targetTab) {
                targetTab.classList.add('active');
            }
        }, { passive: true });
    }

    // Form submission with debounce protection
    let isSubmitting = false;
    if (profileForm && submitBtn) {
        profileForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Prevent double submission
            if (isSubmitting) return;
            isSubmitting = true;

            const span = submitBtn.querySelector('span');
            if (span) {
                span.textContent = 'Kaydediliyor...';
            }
            submitBtn.disabled = true;

            // Simulate API call
            setTimeout(() => {
                if (span) {
                    span.textContent = submitBtnOriginalText;
                }
                submitBtn.disabled = false;
                isSubmitting = false;
                alert('Profil bilgileriniz başarıyla güncellendi!');
            }, 1500);
        }, { passive: false });
    }

    // Cancel button
    if (cancelBtn && profileForm) {
        cancelBtn.addEventListener('click', () => {
            if (confirm('Yaptığınız değişiklikler kaydedilmeyecek. Devam etmek istiyor musunuz?')) {
                profileForm.reset();
            }
        }, { passive: true });
    }

})();

