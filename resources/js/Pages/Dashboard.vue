
<template>
    <div>
        <h1>Welcome, {{ user.name }}</h1>
    </div>
</template>

<script>
export default {
    props: {
        user: Object,
    },
}
</script>

