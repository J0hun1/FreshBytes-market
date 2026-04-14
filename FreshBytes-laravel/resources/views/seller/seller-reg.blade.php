<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Become a Seller | FreshBytes</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Fredoka:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="market-page-body market-subpage-body font-outfit">
    <div class="market-page-wrap">
        @include('layouts.market-navbar')

        <main class="max-w-3xl mx-auto my-8 px-4 md:px-6 lg:px-0">
            <!-- Hero Section -->
            <div class="text-center mb-10 animate-fade-in">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 leading-tight drop-shadow-lg">
                    Become an Official Seller</h1>
                <p class="text-base md:text-lg text-white font-medium max-w-2xl mx-auto leading-relaxed drop-shadow-sm">
                    Join thousands of local farmers & producers. List your fresh produce and reach customers looking for
                    quality at fair prices.</p>
            </div>

            <!-- Seller Registration Form -->
            <form id="sellerForm"
                class="seller-form bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-xl overflow-hidden"
                style="position: relative; z-index: 2;">
                @csrf

                <!-- SECTION: BUSINESS INFO -->
                <div class="form-section p-6 md:p-8 border-b border-white/10">
                    <h3 class="text-xl font-bold text-white mb-5 flex items-center gap-3">
                        <span
                            class="w-10 h-10 bg-green-500/20 rounded-xl flex items-center justify-center text-green-400 font-bold text-lg">1</span>
                        Business Information
                    </h3>

                    <div class="form-group mb-6">
                        <label class="block text-white font-semibold text-base mb-2">Business Name *</label>
                        <input type="text" name="business_name" value="{{ old('business_name') }}" required
                            class="w-full h-12 rounded-xl border border-white/30 bg-black/20 text-white placeholder-white/60 px-4 text-base focus:border-green-400/70 focus:ring-2 focus:ring-green-400/30 focus:bg-white/10 transition-all duration-300">
                        @error('business_name')
                            <span
                                class="error text-red-400 text-sm mt-2 block font-medium animate-pulse">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-white font-semibold text-base mb-2">Business Address *</label>
                        <textarea name="business_address" rows="4" required
                            class="w-full rounded-xl border border-white/30 bg-black/20 text-white placeholder-white/60 p-4 text-base resize-vertical focus:border-green-400/70 focus:ring-2 focus:ring-green-400/30 focus:bg-white/10 transition-all duration-300">{{ old('business_address') }}</textarea>
                        @error('business_address')
                            <span
                                class="error text-red-400 text-sm mt-2 block font-medium animate-pulse">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- SECTION: CONTACT -->
                <div class="form-section two-col p-6 md:p-8">
                    <h3 class="text-xl font-bold text-white mb-5 flex items-center gap-3 col-span-full">
                        <span
                            class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center text-emerald-400 font-bold text-lg">2</span>
                        Contact Information
                    </h3>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                        <div class="form-group">
                            <label class="block text-white font-semibold text-base mb-2">Phone Number *</label>
                            <input type="tel" name="business_phone" value="{{ old('business_phone') }}" required
                                class="w-full h-12 rounded-xl border border-white/30 bg-black/20 text-white placeholder-white/60 px-4 text-base focus:border-emerald-400/70 focus:ring-2 focus:ring-emerald-400/30 focus:bg-white/10 transition-all duration-300">
                            @error('business_phone')
                                <span
                                    class="error text-red-400 text-sm mt-2 block font-medium animate-pulse">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="block text-white font-semibold text-base mb-2">Business Email *</label>
                            <input type="email" name="business_email" value="{{ old('business_email') }}" required
                                class="w-full h-12 rounded-xl border border-white/30 bg-black/20 text-white placeholder-white/60 px-4 text-base focus:border-emerald-400/70 focus:ring-2 focus:ring-emerald-400/30 focus:bg-white/10 transition-all duration-300">
                            @error('business_email')
                                <span
                                    class="error text-red-400 text-sm mt-2 block font-medium animate-pulse">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SECTION: FINANCIAL -->
                <div class="form-section p-6 md:p-8">
                    <h3 class="text-xl font-bold text-white mb-5 flex items-center gap-3">
                        <span
                            class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-400 font-bold text-lg">3</span>
                        Financial Information
                    </h3>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                        <div class="form-group">
                            <label class="block text-white font-semibold text-base mb-2">Tax ID (Optional)</label>
                            <input type="text" name="tax_id" value="{{ old('tax_id') }}"
                                class="w-full h-12 rounded-xl border border-white/30 bg-black/20 text-white placeholder-white/60 px-4 text-base focus:border-blue-400/70 focus:ring-2 focus:ring-blue-400/30 focus:bg-white/10 transition-all duration-300">
                        </div>

                        <div class="form-group">
                            <label class="block text-white font-semibold text-base mb-2">Bank Details *</label>
                            <input type="text" name="bank_account_details" value="{{ old('bank_account_details') }}"
                                required
                                class="w-full h-12 rounded-xl border border-white/30 bg-black/20 text-white placeholder-white/60 px-4 text-base focus:border-blue-400/70 focus:ring-2 focus:ring-blue-400/30 focus:bg-white/10 transition-all duration-300">
                            <small class="text-white/70 text-sm block mt-2 font-medium">Account number, bank name,
                                account holder name</small>
                        </div>
                    </div>
                </div>

                <!-- SUBMIT -->
                <div class="p-6 md:p-8 pt-0">
                    <button type="submit"
                        class="submit-btn w-full h-14 text-lg font-bold rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white shadow-xl hover:shadow-green-500/30 transition-all duration-300 flex items-center justify-center gap-3">
                        Become Official Seller
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Success Modal -->
            <div id="successModal"
                class="fixed inset-0 z-[10000] hidden bg-black/80 backdrop-blur-2xl flex items-center justify-center p-8 font-outfit animate-modal-in">
                <div
                    class="bg-white/95 backdrop-blur-3xl rounded-3xl p-16 md:p-20 max-w-2xl w-full max-h-[90vh] overflow-auto shadow-2xl animate-scale-in">
                    <div
                        class="w-28 h-28 md:w-32 md:h-32 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full mx-auto mb-8 flex items-center justify-center shadow-2xl">
                        <svg class="w-16 h-16 md:w-20 md:h-20 text-green-900" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h2 id="modalMessage"
                        class="text-4xl md:text-5xl font-black text-green-900 mb-6 text-center drop-shadow-lg">Success!
                    </h2>
                    <p class="text-2xl text-gray-700 mb-12 leading-relaxed text-center">You are now an official seller
                        on FreshBytes! Your account is being verified.</p>
                    <div class="flex flex-col sm:flex-row gap-6 justify-center">
                        <a href="{{ route('seller.product.create') }}"
                            class="flex-1 min-w-[200px] h-16 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold text-xl rounded-2xl flex items-center justify-center shadow-2xl hover:shadow-green-500/50 transform hover:-translate-y-1 transition-all duration-300">
                            🚀 Sell Product Now
                        </a>
                        <button onclick="closeModal()"
                            class="flex-1 min-w-[200px] h-16 border-2 border-gray-300 hover:border-gray-400 text-gray-800 font-bold text-xl rounded-2xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 bg-white/80 backdrop-blur-sm">
                            Continue Browsing
                        </button>
                    </div>
                </div>
            </div>

            <!-- Loading Spinner Overlay -->
            <div id="loadingOverlay"
                class="fixed inset-0 z-[9999] hidden bg-black/60 backdrop-blur-md flex items-center justify-center">
                <div
                    class="w-20 h-20 border-4 border-green-400/30 border-t-green-500 rounded-full animate-spin shadow-xl">
                </div>
            </div>
    </div>
    </div>

    <style>
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scale-in {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes modal-in {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }

        .animate-scale-in {
            animation: scale-in 0.5s ease-out;
        }

        .animate-modal-in {
            animation: modal-in 0.3s ease-out;
        }

        .text-shadow-lg {
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #9ee19e !important;
            box-shadow: 0 0 0 4px rgba(158, 225, 158, 0.3) !important;
            background: rgba(255, 255, 255, 0.15) !important;
        }

        @media (max-width: 768px) {
            main {
                margin: 1rem;
                padding: 0;
            }

            .form-section {
                padding: 2rem 1.5rem !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('sellerForm');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const successModal = document.getElementById('successModal');
            const modalMessage = document.getElementById('modalMessage');
            const submitBtn = form.querySelector('.submit-btn');

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(form);
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Creating Seller Account... <div class="w-6 h-6 border-2 border-white/30 border-t-white rounded-full animate-spin ml-2 inline-block"></div>';
                loadingOverlay.classList.remove('hidden');

                fetch(form.action || '/seller/register', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        loadingOverlay.classList.add('hidden');

                        if (data.success) {
                            modalMessage.textContent = data.message;
                            successModal.classList.remove('hidden');
                        } else {
                            alert('Error: ' + (data.message || 'Something went wrong'));
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '🚀 Become Official Seller <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>';
                        }
                    })
                    .catch(error => {
                        loadingOverlay.classList.add('hidden');
                        console.error('Error:', error);
                        alert('Network error. Please try again.');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '🚀 Become Official Seller <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>';
                    });
            });
        });

        function closeModal() {
            document.getElementById('successModal').classList.add('hidden');
            window.location.href = '{{ route("market.home") }}';
        }
    </script>
</body>

</html>