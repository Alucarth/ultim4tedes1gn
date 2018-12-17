<template>
  <v-layout row wrap>
     <v-flex xs12 >
            <v-card >
            <v-card-title primary-title>
              <div>
                <div class="headline"> Especies </div>
              </div>
            </v-card-title>
              <canvas id="especies" ></canvas>
            </v-card>
      </v-flex>
  </v-layout>
</template>
<script>
// console.log(localStorage.getItem('token'));
export default {
  data(){
    return {
        lumbers:null,
        tab:null,       
        dialog: false,
        loading: true,

      }
  },
  methods:{
    createChart(chartId, chartData) {
      const ctx = document.getElementById(chartId);
      const myChart = new Chart(ctx, {
        type: chartData.type,
        data: chartData.data,
        options: chartData.options,
      });
    },
    getCharData(items,type){
      let labels = [];
      let data =[];
      items.forEach(item => {
        labels.push(item.name);
        data.push(item.qty);
      });
      let datasets = [{
        label: '' ,
        data: data,
        backgroundColor: [
        "#f1c40f",
        "#e74c3c",
        "#3498db",
        "#2ecc71",
        "#9b59b6",
        "#34495e",
        "#95a5a6",
        "#FF6384",
        "#1AB394",
        "#FFA365",

        ],
        hoverBackgroundColor: [
        "#f1c40f",
        "#e74c3c",
        "#3498db",
        "#2ecc71",
        "#9b59b6",
        "#34495e",
        "#95a5a6",
        "#FF6384",
        "#1AB394",
        "#FFA365" 
        ],
        borderWidth: 1
      }];
      return {type: type,data:{labels, datasets}};
    },
    load(){
          
        return new Promise((resolve,reject)=>{   
            this.getData('api/report').then((data)=>{
                
                this.lumbers = data.species;
               
                console.log(data);
                resolve();
            });
        });
    },
    getData(url,parameters){
        return new Promise((resolve,reject)=>{
            this.loading = true;
            axios.get(url)
                .then((response) => {
                    this.loading = false;
                    resolve(response.data);
                });
        });
    }
  },
  mounted(){
    this.load().then(()=>{
        this.createChart('especies',this.getCharData(this.lumbers,'bar'));
      
    });
  }
}
</script>
