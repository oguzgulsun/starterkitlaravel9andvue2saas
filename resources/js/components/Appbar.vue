<template lang="">
    <div>
       <v-container class="fill-height notification-area"  >

            <v-responsive width="500" style="margin-right: 15px;" id="notification-searchbar">
                  <v-autocomplete
                  hide-no-data
                  v-model="select"
                  :items="items"
                  :loading="loading"
                  :search-input.sync="search"
                  background-color="#ededed"
                  clearable
                  hide-details
                  hide-selected
                  item-text="name"
                  item-value="symbol"
                  label="Search"
                  solo
                  :menu-props="{closeOnContentClick:true}"
                
                  >
                  <template v-slot:item="data">
                    <div class="aclinkdiv">
                           <router-link :to="data.item.path"  class="nav-link aclink">
                          <v-list-item
                          link

                            @click="clearAutocomplete"
                          >
                            <v-list-item-content>
                              <v-list-item-title>  
                                {{ data.item.name }}    
                              </v-list-item-title>
                            </v-list-item-content>
                          </v-list-item>
                          </router-link> 
                    </div>
                  </template>
      
                </v-autocomplete>
            </v-responsive>
        
            <v-spacer></v-spacer>
            <v-menu offset-y>
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  color="transparent"
                  v-bind="attrs"
                  v-on="on"
                  style="height:44px"
                >
                <v-badge
          color="#f7b84b"
          :content="countunread"
          v-if="notifications.length > 0"
        >
          <v-icon color="#696969">mdi-bell-outline</v-icon>
        </v-badge>
          <v-icon v-if="notifications.length == 0" color="#696969">mdi-bell-outline</v-icon>
                </v-btn>
              </template>
              <v-list style="background-color: #e8e8e8;"  v-if="notifications.length<=5">
                <v-list-item
                
                  v-for="(note,index) in notifications"
                  :key="index"
                  v-bind:class="{okunmamis : note.okundu===0}" 
                >
                   <!-- <v-list-item-title   link  @click="okunduodeme(note.id,index)"  >{{ note.note }}</v-list-item-title> -->
                  <v-list-item-title  link  @click="okundu(note.id,index)"  >{{ note.note }}</v-list-item-title>
                </v-list-item>

           
              </v-list> 
              <v-list style="background-color: #e8e8e8;"    v-else>
                     <v-list-item
               
                  v-for="(note,index) in notifications.slice(0,5)"
                  :key="index"
                  v-bind:class="{okunmamis : note.okundu===0}" 
                >
                   <!-- <v-list-item-title   link  @click="okunduodeme(note.id,index)"  >{{ note.note }}</v-list-item-title> -->
                  <v-list-item-title  link  @click="okundu(note.id,index)"  >{{ note.note }}</v-list-item-title>
                </v-list-item>
                <router-link to="/notifications"  class="nav-link "> 
                   <v-list-item
                   style="min-height: unset;"
                >
                 
                  <v-list-item-title  link style="min-height: 13px;
    padding: 9px 0 2px 0;
    text-align: center;" >  {{notifications.length-5+" more" }}  </v-list-item-title>
                </v-list-item> </router-link>


              </v-list>
            </v-menu>
            <v-spacer></v-spacer>


             <v-menu
        v-model="showMenu"
        bottom
        min-width="200px"
        rounded
        offset-y
        :close-on-click="false"
        :close-on-content-click="false"
      >
        <template v-slot:activator="{ on , attrs }">
          <v-btn
            icon
            x-large
            v-on="on"
            v-bind="attrs"
            style="margin-left: 10px;  margin-bottom: 3px;"
           
          >
             <v-avatar
               v-if="user.avatar==null"
                 size="45"
                style="background-color: darkgreen;color:white;"

              >
               <v-icon dark dense>
                  mdi-account-circle  
                </v-icon>
               </v-avatar>

                <v-avatar
                v-else
                 size="40"
                
                >
               <img
                :src="user.avatar"
                :alt="user.name"
              >
            </v-avatar>
          </v-btn>
        </template>
        <v-card>
          <v-list-item-content class="justify-center">
            <div class="mx-auto text-center">
              <v-avatar
               v-if="user.avatar==null"
                 size="40"
                 style="background-color: darkgreen;color:white;margin-left: 10px;  margin-bottom: 4px;"
              >
              <v-icon dark>
                  mdi-account-circle
                </v-icon>
              </v-avatar>
              <v-avatar
                v-else
                 size="40"
                 style="margin-left: 10px;  margin-bottom: 4px;"
              >
              <img
                :src="user.avatar"
                :alt="user.name"
              >
              </v-avatar>
              <h3 lass="text-caption mt-1">{{ user.name }}</h3>
              <p class="text-caption mt-1 mb-1">
                {{ user.email }}
              </p>
            <v-divider class="my-3"></v-divider>
   
              <!-- <v-divider class="my-3"></v-divider> -->
              <router-link to="/profile"  class="nav-link "> 
              <v-btn
                depressed
                rounded
                text
                v-on:click.after="showMenu=false"
              >
               Profile
              </v-btn>
              </router-link>
              <v-divider class="my-3"></v-divider>
              <v-btn
                depressed
                rounded
                text
                v-on:click.after="showMenu=false"
                @click="logout()"
              >
                Logout
              </v-btn>
            </div>
          </v-list-item-content>
        </v-card>
      </v-menu>
          </v-container>
    </div>
</template>
<script>
export default {
    name:"AppbarGroup",
    props: ['routes'],
    data() {
        return {
      showMenu:false,

          loading: false,
        items: [],
     
        search: null,
        select: null,
        }
    },
     watch: {
      search (val) {
        val && val !== this.select && this.querySelections(val)
      },
    },
    computed: {                
    
       user:{
          get(){
          return this.$store.state.user
          },
          set(value){
          this.$store.commit('SET_USER',value)
          }
      },
      countunread(){
          var okunmamislar = this.$store.state.notifications.filter(function (item) {
            return item.okundu == 0;
          });
          return okunmamislar.length;
      },
      notifications:{
          get(){
          return this.$store.state.notifications
        },
        set(value){
        this.$store.commit('SET_NOTIFICATIONS',value)
        }
      },
    },
        methods: {
          clearAutocomplete(){
              this.search =""
              this.items = []

          },
      querySelections (v) {
        this.loading = true
        // Simulated ajax query
        setTimeout(() => {
          this.items = this.routes.filter(e => {
            return (e.name || '').toLowerCase().indexOf((v || '').toLowerCase()) > -1
          })
          this.loading = false
        }, 500)
      },
     
  
      okundu(id,index){
        this.$router.push({ path: '/notifications', query: { notification: id } })
      },
      logout(){
      window.location.href = '/logout';
      },
    
    },
  
}
</script>
<style lang="css">
  @media screen and (max-width: 992px) {
  .notification-area {
        display: flex;
    justify-content: flex-end;
        flex-wrap: unset!important;
    align-items: unset!important;
  }
  #notification-searchbar{
    display: none;
  }
  #notification-lang{
    display: none;
  }
}
.okunmamis{
      background-color: white;

}
.okunmamis .v-list-item__title{
  color: indigo;
    font-size: 12px;
    padding: 9px 0;
    cursor: pointer;
}
.aclink{
    width: 100%;
    height: 100%;
    cursor: pointer;
}
.aclinkdiv{
    width: 100%;
    height: 100%;
    pointer-events: all;
    cursor: pointer!important;
}
</style>