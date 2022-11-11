<template lang="">
<div>
 <v-sheet
        color="white lighten-4"
        style="height: 100%;padding: 30px 0 0 0;margin-top:64px;"
      >
      <v-list class="pt-2">
      <router-link to="/" class="nav-link" >
        <v-list-item
        link
        >
          <v-list-item-icon>
            <v-icon>mdi-view-dashboard</v-icon>
          </v-list-item-icon>
            <v-list-item-title>  
              {{ "Dashboard" }}
            </v-list-item-title>
        </v-list-item>
      </router-link>

      <router-link v-for="(route, index) in routes" :key="index" :to="route.path"  class="nav-link " >
        <v-list-item link>
          <v-list-item-icon>
            <v-icon>{{ route.icon }} </v-icon>
          </v-list-item-icon>
          <v-list-item-title >  
            {{ route.name }}
          </v-list-item-title>
        </v-list-item>
      </router-link>

      </v-list>
</v-sheet>
</div>
  
  
</template>
<script>
export default {
    name:'SidebarGroup',
    props: ['routes'],
}
</script>
<style lang="css">
.nav-link{
  text-decoration: none;
}
 .nav-link:hover .v-list-item{
     background-color: #ededed;
  }
</style>