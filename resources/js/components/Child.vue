<template>
    <transition name="page" mode="out-in">
        <v-content>
            <transition name="fade">
                <router-view></router-view>
            </transition>
        </v-content>
    </transition>
</template>

<script>
    export default {
        name: 'Child'
    }
</script>
