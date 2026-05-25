<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">How to Use Phantom 5</h1>
            <p class="text-gray-500 mb-10">A quick guide to help you get the most out of the platform.</p>

            @if(Auth::user()->isAdmin())
            {{-- Admin Guide --}}
            <div class="space-y-8">
                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">1</span>
                        Admin Dashboard
                    </h2>
                    <p class="text-gray-600 leading-relaxed">Your dashboard gives you a snapshot of the entire platform. You can see total users, pending merchant applications, pending payments, active subscriptions, and recent orders. Access it from your profile dropdown.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">2</span>
                        Reviewing Merchant Applications
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-3">When someone applies to become a merchant, their application appears in the Merchants section. You will see their passport photo, business name, business description, and payment proof for their first subscription.</p>
                    <p class="text-gray-600 leading-relaxed">Click "Review" to view full details, then approve or reject the application. The merchant will receive an email notification with the decision.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">3</span>
                        Site Settings
                    </h2>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        <div>
                            <h3 class="font-semibold text-slate-800">Bank Details</h3>
                            <p>Set the bank name, account name, and account number. This is displayed to merchants when paying for subscriptions and to customers when paying for orders.</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-800">Subscription Plans</h3>
                            <p>Create and manage plans that merchants subscribe to. Each plan has a name, price in Naira, and duration in days. Toggle "Active" to show or hide a plan from merchants. Check "Premium" on any plan to give its subscribers featured home page listing benefits.</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-800">Featured Listings Settings</h3>
                            <p class="mb-2">These settings control how premium merchant listings rotate on the home page:</p>
                            <ul class="list-disc list-inside space-y-1 text-gray-500">
                                <li><strong class="text-gray-700">Max Listings Per Merchant</strong> &mdash; The maximum number of listings pulled from each premium merchant. For example, if set to 10, only the 10 most recent listings from each merchant are used.</li>
                                <li><strong class="text-gray-700">Rotation Interval (seconds)</strong> &mdash; How many seconds each slide stays visible before automatically rotating to the next one.</li>
                                <li><strong class="text-gray-700">Per Slide</strong> &mdash; The total number of listings shown in each slide for that category.</li>
                                <li><strong class="text-gray-700">Per Row</strong> &mdash; How many listings fit in one row. For example, if Per Slide is 8 and Per Row is 4, you get 2 rows of 4 items.</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">4</span>
                        Posting Listings
                    </h2>
                    <p class="text-gray-600 leading-relaxed">As admin, you can post properties, products, and services from the Merchant Dashboard. Go to your profile dropdown, click "Merchant Dashboard", then navigate to Properties, Products, or Services and click "Create". Your listings are automatically featured on the home page without needing a subscription.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">5</span>
                        Payments & Orders
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-3">When a customer places an order and uploads payment proof, it appears in the Payments section. Click on a payment to view the proof image and details, then confirm or reject it.</p>
                    <p class="text-gray-600 leading-relaxed">The Orders section shows all orders across the platform. You can update order statuses and view order details.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">6</span>
                        Managing Users & Subscriptions
                    </h2>
                    <p class="text-gray-600 leading-relaxed">From the Users section, you can view all registered accounts, suspend or unsuspend users. The Subscriptions section lets you monitor active subscriptions and see which ones are expiring soon.</p>
                </section>
            </div>

            @elseif(Auth::user()->isMerchant())
            {{-- Merchant Guide --}}
            <div class="space-y-8">
                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">1</span>
                        Getting Started
                    </h2>
                    <p class="text-gray-600 leading-relaxed">Once your merchant application is approved and your subscription is active, you can access the Merchant Dashboard from your profile dropdown. This is your central hub for managing everything.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">2</span>
                        Creating Listings
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-3">From your Merchant Dashboard, navigate to Properties, Products, or Services and click "Create" to add a new listing. Upload images, set your price, write a description, and choose a category.</p>
                    <p class="text-gray-600 leading-relaxed">An active subscription is required to create or edit listings. If your subscription expires, your existing listings remain visible but you cannot add new ones until you renew.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">3</span>
                        Subscription Plans
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-3">Choose from available plans: Monthly, Yearly, or Premium Yearly. To subscribe or renew, go to "Subscription" in your profile dropdown, select a plan, transfer payment to the displayed bank account, and upload your payment proof.</p>
                    <p class="text-gray-600 leading-relaxed">The admin will review and activate your subscription. You will receive an email when it is confirmed.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">4</span>
                        Premium Featured Listings
                    </h2>
                    <p class="text-gray-600 leading-relaxed">Upgrade to a Premium plan to get your listings automatically featured on the home page. Your most recent listings will rotate in the featured carousel, giving your business maximum exposure to all visitors.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">5</span>
                        Managing Orders
                    </h2>
                    <p class="text-gray-600 leading-relaxed">When customers place orders for your listings, they appear in the Orders section of your Merchant Dashboard. You can view order details, see payment status, and coordinate delivery with the buyer.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">6</span>
                        Business Profile
                    </h2>
                    <p class="text-gray-600 leading-relaxed">Keep your business profile updated from the Merchant Dashboard. Your business name, description, and contact information are visible to customers on your listing pages.</p>
                </section>
            </div>

            @else
            {{-- Customer/Buyer Guide --}}
            <div class="space-y-8">
                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">1</span>
                        Browsing Listings
                    </h2>
                    <p class="text-gray-600 leading-relaxed">Explore properties for sale or rent, building products, and professional services from the navigation menu. Use category filters to narrow down results and find exactly what you are looking for.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">2</span>
                        Placing an Order
                    </h2>
                    <p class="text-gray-600 leading-relaxed">Found something you like? On the listing page, click the order button, specify the quantity, add any notes for the merchant, and submit your order.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">3</span>
                        Making Payment
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-3">After placing an order, you will see the bank account details to transfer payment to. Make the transfer, then go to your order and upload a screenshot or photo of your payment receipt as proof.</p>
                    <p class="text-gray-600 leading-relaxed">The admin will verify your payment and update the order status. You will be able to track progress from "My Orders" in your profile dropdown.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">4</span>
                        Tracking Your Orders
                    </h2>
                    <p class="text-gray-600 leading-relaxed">Go to "My Orders" from your profile dropdown to see all your orders and their current status. You can view payment details, order items, and cancel any pending orders if needed.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">5</span>
                        Contacting Merchants
                    </h2>
                    <p class="text-gray-600 leading-relaxed">Have questions about a listing? Use the inquiry form on any listing page to send a message directly to the merchant. You can also reach us through the Contact page for general questions.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-sm font-bold">6</span>
                        Becoming a Seller
                    </h2>
                    <p class="text-gray-600 leading-relaxed">Want to sell on Phantom 5? Click "Become a Seller" in your profile dropdown. Fill in your business details, upload your passport photo, select a subscription plan, transfer payment, and upload payment proof. Once the admin approves your application, you can start listing.</p>
                </section>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
