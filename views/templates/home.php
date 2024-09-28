<div class="bg-gray-100 flex flex-col min-h-screen">
    <!-- Top Header -->
    <header class="fixed top-0 w-full bg-white shadow-lg z-10">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <!-- Brand -->
            <div class="flex items-center space-x-2">
                <i class="fas fa-bolt text-2xl text-indigo-600"></i>
                <span class="ml-2 text-2xl font-semibold">Photogram</span>
            </div>

            <!-- Search Bar -->
            <div class="flex-1 mx-4 hidden">
                <div class="relative">
                    <input type="text" placeholder="Search" class="w-full py-2 pl-10 pr-4 rounded-full bg-gray-200 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">
                    <i class="fas fa-search absolute top-2 left-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-4">
                <button class="relative text-gray-600 px-3 py-2 focus:outline-none rounded-full hover:bg-indigo-50 bg-slate-50">
                    <i class="fas fa-paper-plane text-lg"></i>
                </button>
                <button class="relative text-gray-600 px-3 py-2 focus:outline-none rounded-full hover:bg-indigo-50 bg-slate-50">
                    <i class="fas fa-bell text-lg"></i>
                </button>
                <button id="openModal" class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-500 focus:outline-none">
                    <i class="fas fa-plus"></i> Create Post
                </button>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <div class="flex flex-1 pt-16">
        <!-- Sidebar -->
        <aside class="hidden md:block fixed left-0 top-16 w-64 bg-white border-r border-gray-200 p-4 h-[calc(100vh-4rem)] overflow-y-auto">
            <nav>
                <ul>
                    <li class="p-3 hover:bg-slate-50 rounded-lg">
                        <a href="#" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
                            <i class="fas fa-home text-lg mr-2"></i>
                            <span>News Feed</span>
                        </a>
                    </li>
                    <li class="p-3 hover:bg-slate-50 rounded-lg">
                        <a href="#" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
                            <i class="fas fa-search text-lg mr-3"></i>
                            <span>Explore</span>
                        </a>
                    </li>
                    <li class="p-3 hover:bg-slate-50 rounded-lg">
                        <a href="#" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
                            <i class="fas fa-video text-lg mr-2"></i>
                            <span>Reels</span>
                        </a>
                    </li>
                    <li class="p-3 hover:bg-slate-50 rounded-lg">
                        <a href="#" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
                            <i class="fas fa-shopping-bag text-lg mr-3"></i>
                            <span>Shop</span>
                        </a>
                    </li>
                    <li class="p-3 hover:bg-slate-50 rounded-lg">
                        <a href="#" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
                            <i class="fas fa-bookmark text-lg mr-3"></i>
                            <span>Saved</span>
                        </a>
                    </li>
                    <li class="p-3 hover:bg-slate-50 rounded-lg">
                        <a href="#" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
                            <i class="fas fa-chart-line text-lg mr-2"></i>
                            <span>Insights</span>
                        </a>
                    </li>
                    <li class="p-3 hover:bg-slate-50 rounded-lg">
                        <a href="#" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
                            <i class="fas fa-archive text-lg mr-2"></i>
                            <span>Archive</span>
                        </a>
                    </li>
                    <li class="p-3 hover:bg-slate-50 rounded-lg">
                        <a href="#" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
                            <i class="fas fa-qrcode text-lg mr-2"></i>
                            <span>QR Code</span>
                        </a>
                    </li>
                    <li class="p-3 hover:bg-slate-50 rounded-lg">
                        <a href="#" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
                            <i class="fas fa-cog text-lg mr-2"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="mt-8 p-3 hover:bg-red-50 rounded-lg">
                <a href="#" class="text-gray-600 hover:text-red-600">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ms-64 me-64 p-6 space-y-6 overflow-y-auto">
            <!-- Stories Section -->
            <section class="bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-bold mb-4">Stories</h2>
                <div class="flex space-x-4 overflow-x-auto pb-3">
                    <!-- Story Item -->
                    <div class="flex-shrink-0 w-16 h-16 bg-gray-300 rounded-full overflow-hidden">
                        <img src="https://via.placeholder.com/64" alt="Story" class="object-cover w-full h-full">
                    </div>
                    <div class="flex-shrink-0 w-16 h-16 bg-gray-300 rounded-full overflow-hidden">
                        <img src="https://via.placeholder.com/64" alt="Story" class="object-cover w-full h-full">
                    </div>
                    <div class="flex-shrink-0 w-16 h-16 bg-gray-300 rounded-full overflow-hidden">
                        <img src="https://via.placeholder.com/64" alt="Story" class="object-cover w-full h-full">
                    </div>
                    <div class="flex-shrink-0 w-16 h-16 bg-gray-300 rounded-full overflow-hidden">
                        <img src="https://via.placeholder.com/64" alt="Story" class="object-cover w-full h-full">
                    </div>
                    <div class="flex-shrink-0 w-16 h-16 bg-gray-300 rounded-full overflow-hidden">
                        <img src="https://via.placeholder.com/64" alt="Story" class="object-cover w-full h-full">
                    </div>
                    <div class="flex-shrink-0 w-16 h-16 bg-gray-300 rounded-full overflow-hidden">
                        <img src="https://via.placeholder.com/64" alt="Story" class="object-cover w-full h-full">
                    </div>
                    <div class="flex-shrink-0 w-16 h-16 bg-gray-300 rounded-full overflow-hidden">
                        <img src="https://via.placeholder.com/64" alt="Story" class="object-cover w-full h-full">
                    </div>
                    <div class="flex-shrink-0 w-16 h-16 bg-gray-300 rounded-full overflow-hidden">
                        <img src="https://via.placeholder.com/64" alt="Story" class="object-cover w-full h-full">
                    </div>
                    <div class="flex-shrink-0 w-16 h-16 bg-gray-300 rounded-full overflow-hidden">
                        <img src="https://via.placeholder.com/64" alt="Story" class="object-cover w-full h-full">
                    </div>
                </div>
            </section>

            <!-- News Feed Section -->
            <section class="bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-bold mb-4">News Feed</h2>
                <!-- Single Post -->
                <article class="bg-white p-4 rounded-lg shadow mb-4">
                    <div class="flex items-center mb-4">
                        <img src="https://via.placeholder.com/40" alt="User" class="w-10 h-10 rounded-full mr-2">
                        <div>
                            <h3 class="font-semibold">User Name</h3>
                            <p class="text-sm text-gray-500">Location - 20 July</p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <img src="https://via.placeholder.com/600x400" alt="Post" class="w-full rounded-lg">
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-4">
                            <button class="text-gray-500 hover:text-red-500">
                                <i class="fas fa-heart"></i> 123
                            </button>
                            <button class="text-gray-500 hover:text-indigo-600">
                                <i class="fas fa-comment"></i> 15
                            </button>
                            <button class="text-gray-500 hover:text-indigo-600">
                                <i class="fas fa-share"></i>
                            </button>
                        </div>
                        <button class="text-gray-500 hover:text-indigo-600">
                            <i class="fas fa-bookmark"></i>
                        </button>
                    </div>
                </article>
                <!-- More Posts as needed -->
            </section>
        </main>

        <!-- Right Sidebar -->
        <aside class="hidden lg:block fixed right-0 top-16 w-64 bg-white border-l border-gray-200 p-4 h-[calc(100vh-4rem)] overflow-y-auto">
            <section class="mb-6">
                <h2 class="text-lg font-bold mb-4">Insights</h2>
                <!-- Insights Chart -->
                <div class="bg-gray-100 rounded-lg p-4">
                    <img src="https://via.placeholder.com/240x180" alt="Chart">
                </div>
            </section>
            <section>
                <h2 class="text-lg font-bold mb-4">Suggestions For You</h2>
                <ul class="space-y-4">
                    <li class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="https://via.placeholder.com/40" alt="User" class="w-10 h-10 rounded-full mr-2">
                            <div>
                                <h3 class="font-semibold text-sm">User Name</h3>
                                <p class="text-xs text-gray-500">Followed by X and Y</p>
                            </div>
                        </div>
                        <button class="bg-indigo-600 text-white rounded-full px-3 py-1 text-sm">Follow</button>
                    </li>
                    <!-- More Suggestions as needed -->
                </ul>
            </section>
        </aside>
    </div>
</div>