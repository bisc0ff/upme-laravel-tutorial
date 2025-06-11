<script setup>

import AppHeader from "../Pages/Components/AppHeader.vue"

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
        <AppHeader />

        <main>
            <div class="m-4 h-full flex flex-col">
                <slot />
            </div>
        </main>
>
</template>
