<template>
    <div>
    
    </div>
</template>

<script>
export default {
    created()
    {
        Helper.logout();
        this.$router.push({name: '/'});
        Toast.fire({
            icon: 'success',
            title: 'You are log out!'
        });
    }
}
</script>

<style scoped>

</style>