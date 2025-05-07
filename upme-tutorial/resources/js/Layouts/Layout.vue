<script setup>

</script>

<template>
    <Head>
        <title>My app</title>
        <meta   
            head-key="description" 
            name="description" 
            content="my app description"
        />
    </Head>

    <div>
        <header class="text-white">
            <nav class="flex items-center justify-between px-4 py-2 max-w-screen-lg mx-auto">
                <div class="space-x-6">
                    <Link :href="route('home')" 
                        class="nav-link" :class="{'bg-slate-700' : $page.component === 'Home'}">Home
                    </Link>

                    <Link :href="route('about')" class="nav-link" :class="{'bg-slate-700' : $page.component === 'About'}">About</Link>
                    
                    <Link  v-if="$page.props.auth.user" :href="route('dashboard')" class="nav-link" :class="{'bg-slate-700' : $page.component === 'Dashboard'}">Dashboard</Link>
                </div>

                <div v-if="$page.props.auth.user" class="space-x-6 mb-1 flex">
                    <img class="avatar" 
                         :src="$page.props.auth.user.avatar? ( '/storage/' + $page.props.auth.user.avatar ) : ('storage/avatars/default.jpg')"
                         alt="">

                    <Link :href="route('register')" class="nav-link" :class="{'bg-slate-700' : $page.component === 'Auth/Register'}">Register</Link>
                    
                    <Link 
                        :href="route('logout')" 
                        method="post" 
                        as="button" 
                        class="nav-link">Logout
                    </Link>
                </div>

                <div v-else class="space-x-6 mb-1">
                   <Link :href="route('login')" class="nav-link" :class="{'bg-slate-700' : $page.component === 'Auth/Login'}">Login</Link>
                </div> 
            </nav>
        </header>

        <main class="p-4">
            <slot />
        </main>
    </div>
</template>
