<nav class="xl:pl-60 sticky left-0 top-0 z-50 w-full bg-white shadow dark:bg-neutral-800">
    <div class="px-3">
        <div class="relative flex h-[58px] items-center justify-between">
            <div class="flex flex-1 items-center sm:items-stretch sm:justify-start">
                <div class="flex flex-shrink-0 items-center">
                    <x-hamburger />
                </div>
                <div class="ml-auto hidden items-center sm:flex">
                    <div class="flex">
                        <a href="/license/" class="hidden py-2 text-neutral-500 hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 dark:text-neutral-200 dark:hover:text-neutral-300 dark:focus:text-neutral-300 sm:block sm:px-2 [&.active]:text-black/90 dark:[&.active]:text-zinc-400">IPD Lists</a>
                        <a href="#" class="hidden py-2 text-neutral-500 hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 dark:text-neutral-200 dark:hover:text-neutral-300 dark:focus:text-neutral-300 lg:block lg:px-2 [&.active]:text-black/90 dark:[&.active]:text-zinc-400">ส่งเวร</a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-0 sm:static sm:inset-auto sm:ml-4">
                <div id="theme-switcher" class="w-8">
                    <button class="rounded-2 flex items-center justify-center whitespace-nowrap px-1.5 py-2 uppercase text-neutral-500 transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 motion-reduce:transition-none dark:text-neutral-200 dark:hover:text-neutral-300 dark:focus:text-neutral-300 sm:p-2" type="button" id="themeSwitcher" data-te-dropdown-toggle-ref="" data-te-dropdown-position="dropend" aria-expanded="false" fdprocessedid="1w27nh">
                        <x-icon.sun />
                    </button>
                    <ul class="absolute z-[1000] float-left m-0 hidden w-[120px] list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-800 [&[data-te-dropdown-show]]:block" aria-labelledby="themeSwitcher" data-te-dropdown-menu-ref>
                        <li>
                            <a class="block w-full whitespace-nowrap bg-transparent px-3 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 focus:bg-neutral-200 focus:outline-none active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-100 dark:hover:bg-neutral-600 focus:dark:bg-neutral-600" href="#" data-theme="light" data-te-dropdown-item-ref="">
                                <div class="pointer-events-none">
                                    <div class="inline-block w-[24px] text-center align-middle text-primary-500" data-theme-icon="light">
                                        <x-icon.sun />
                                    </div>
                                    <span data-theme-name="light" class="text-primary-500">Light</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="block w-full whitespace-nowrap bg-transparent px-3 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 focus:bg-neutral-200 focus:outline-none active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-100 dark:hover:bg-neutral-600 focus:dark:bg-neutral-600" href="#" data-theme="dark" data-te-dropdown-item-ref="">
                                <div class="pointer-events-none">
                                    <div class="-mt-1 inline-block w-[24px] text-center align-middle" data-theme-icon="dark">
                                        <x-icon.moon />
                                    </div>
                                    <span data-theme-name="dark">Dark</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="block w-full whitespace-nowrap bg-transparent px-3 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 focus:bg-neutral-200 focus:outline-none active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-100 dark:hover:bg-neutral-600 focus:dark:bg-neutral-600" href="#" data-theme="system" data-te-dropdown-item-ref="">
                                <div class="pointer-events-none">
                                    <div class="inline-block w-[24px] text-center" data-theme-icon="system">
                                        <x-icon.system />
                                    </div>
                                    <span data-theme-name="system">System</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div id="profile-popup" class="w-8">
                    <button class="rounded-2 flex items-center justify-center whitespace-nowrap px-1.5 py-2 uppercase text-neutral-500 transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 motion-reduce:transition-none dark:text-neutral-200 dark:hover:text-neutral-300 dark:focus:text-neutral-300 sm:p-2" type="button" id="themeSwitcher" data-te-dropdown-toggle-ref="" data-te-dropdown-position="dropend" aria-expanded="false" fdprocessedid="1w27nh">
                        <i class="fas fa-user-circle"></i>
                    </button>
                    <ul class="absolute z-[1000] float-left m-0 hidden w-[120px] list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-800 [&[data-te-dropdown-show]]:block"
                        aria-labelledby="profilePopup"
                        data-te-dropdown-menu-ref
                    >
                        <li>
                            <a class="block w-full whitespace-nowrap bg-transparent px-3 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 focus:bg-neutral-200 focus:outline-none active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-100 dark:hover:bg-neutral-600 focus:dark:bg-neutral-600" href="#" data-theme="light" data-te-dropdown-item-ref="">
                                <div class="pointer-events-none">
                                    <div class="inline-block w-[24px] text-center align-middle text-primary-500" data-theme-icon="light">
                                        <i class="fas fa-user-cog"></i>
                                    </div>
                                    <span data-theme-name="light" class="text-primary-500">Profile</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="block w-full whitespace-nowrap bg-transparent px-3 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 focus:bg-neutral-200 focus:outline-none active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-100 dark:hover:bg-neutral-600 focus:dark:bg-neutral-600" href="#" data-theme="dark" data-te-dropdown-item-ref="">
                                <div class="pointer-events-none">
                                    <div class="-mt-1 inline-block w-[24px] text-center align-middle" data-theme-icon="dark">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <span data-theme-name="dark">Preferences</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="block w-full whitespace-nowrap bg-transparent px-3 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 focus:bg-neutral-200 focus:outline-none active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-100 dark:hover:bg-neutral-600 focus:dark:bg-neutral-600" href="#" data-theme="system" data-te-dropdown-item-ref="">
                                <div class="pointer-events-none">
                                    <div class="inline-block w-[24px] text-center" data-theme-icon="system">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                    </div>
                                    <span data-theme-name="system">Logout</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
