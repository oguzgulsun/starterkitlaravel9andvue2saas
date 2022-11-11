<template>
   <v-app>
      <v-navigation-drawer
      absolute
        permanent
        expand-on-hover
      >
      <Sidebar :routes="routes" />
      </v-navigation-drawer>
      <v-app-bar app color="#dedede">
        <v-spacer></v-spacer>
        <div class="float-right">
          <Appbar :routes="routes"/>
        </div>
      </v-app-bar>
      <v-main style="padding-left:56px;">
        <div>
         <router-view ></router-view>
        </div> 
        <footer style="position:relative;border-top: 1px solid white;margin-top: 10px;">
        <p style="position: absolute; right:16px; top:9px; color:#fff">2023 </p>
        </footer>
      </v-main>
    </v-app>
</template>

<script>
import Sidebar from '../components/Sidebar';
import Appbar from '../components/Appbar';
export default {
  data() {
    return {
      drawer: false,
      msg: 'Hello world!',
      routes:[]
    }
  },
  components:{Sidebar,Appbar},
}
</script>

<style>
.example {
  color: red;
}
</style>