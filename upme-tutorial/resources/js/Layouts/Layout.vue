<script setup>

</script>

<template>
    <Head>
        <title>My app</title>

       <!-- use head-key if we want to set the meta tag for each page separately -->
        <meta   
            head-key="description" 
            name="description" 
            content="my app description"
        />
    </Head>
    <div>
        <header class="text-white">
            <nav class="flex items-center justify-between p-f max-w-screen-lg mx-auto">
                <div class="space-x-6">
                    <!-- the Link tag ensures we don't reload the page completely 
                     and so that it doesn't call the server when switching pages
                     
                     Also look into Single Page application (SPA)-->
                    <Link :href="route('home')">Home</Link>
                    <Link :href="route('about')">About</Link>
                    <Link :href="route('register')">Register</Link>
                    <Link :href="route('login')">Login</Link>
                </div>
            </nav>
        </header>
        <main class="p-4">

            <!-- this is there the component will be rendered when using this layout -->
            <slot />
        </main>
    </div>
</template>