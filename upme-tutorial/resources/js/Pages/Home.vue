<script setup>

</script>

<template>
        <Head>
                <title>{{ $page.component }}</title>

                 <!-- use head-key if we want to set the meta tag for each page separately -->
                <meta   
                        head-key="description" 
                        name="description" 
                        content="home description"
                />
        </Head>
        <h1>Hello, {{ $page.props.auth.user }}! This is the homepage.</h1>
        <!--  you can access any data in the page using the $page object -->
        <h1> {{ $page }}</h1>


        
       <!-- preserve-scroll is used to keep the scroll in position after page is refreshed or
                 when we press an link/element -->
        <Link class="mt-[600px] block" href="/" preserve-scroll> Refresh</Link>
</template>