<template>
 
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Login form</v-toolbar-title>
              
              </v-toolbar>
              <v-form>
              <v-card-text>
                
                  <v-text-field prepend-icon="person" name="login" label="Login" type="text" v-model="form.email" ></v-text-field>
                  <v-text-field id="password" prepend-icon="lock" name="password" label="Password" type="password" v-model="form.password"></v-text-field>
              
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="authenticate">Login</v-btn>
              </v-card-actions>

                </v-form>
            </v-card>
        
</template>
<script>
import {login} from '../../helpers/auth';
export default {
    name: "login",
    data(){
        return{
            form:{
                email:'',
                password:''
            },
            error:null
        };
    },
    methods:{
        authenticate(){
            this.$store.dispatch('login');
            login(this.$data.form)
                .then((res)=>{
                    this.$store.commit("loginSuccess",res);
                    this.$router.push({path: '/'});

                })
                .catch((error)=>{
                    this.$store.commit("loginFailded",{error});
                })
        }
    }

}
</script>
