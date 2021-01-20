<template>
        <v-app-bar
            fixed
            color="green"
            dark
        >
            <v-toolbar-title>Единый реестр животных</v-toolbar-title>

            <v-spacer></v-spacer>
            <v-btn icon>
                <v-avatar
                    tile
                    color="secondary"
                    size="40"
                >      <v-icon light>
                    mdi-face
                </v-icon></v-avatar>
            </v-btn>
        </v-app-bar>
</template>

<script>
export default {
    name: "Navbar"
}
</script>

<style scoped>

</style>
