<script setup>

import AppHeader from "../Pages/Components/AppHeader.vue"
import AppSidebar from "../Pages/Components/AppSidebar.vue";


</script>

<!-- global layout -->
<template>
    <Head>
        <title>My app</title>
        <meta   
            head-key="description" 
            name="description" 
            content="my app description"
        />
    </Head>
    <body class="min-h-screen flex flex-col">
        <AppHeader />

        <div class="flex flex-1">
            <AppSidebar />
            
            <main class="flex-1 p-6">
                <div class="">
                    <slot />
                </div>
            </main>
        </div>
    </body>

</template>
