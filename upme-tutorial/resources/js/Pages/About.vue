<script setup>

    //receive data from the server
    defineProps({
        user: String 
    })

</script>

<template>
    <Head>
            <title>About</title>

                <meta   
                        head-key="description" 
                        name="description" 
                        content="about description"
                />
        </Head>

    <div>
        About Page Hello user: {{ user }}
    </div>
</template>