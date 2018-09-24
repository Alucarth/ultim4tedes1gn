<template>
  <div class="text-xs-center">
    {{title}}
    <v-menu
      v-model="menu"
      :close-on-content-click="false"
      :nudge-width="80"
      offset-x
      small
    >
      <v-btn
        slot="activator"
        icon
        small=""
      >
       <v-icon>fa-filter</v-icon>
      </v-btn>

      <v-card>
        <v-text-field
        v-model="keyword"
        append-icon="search"
        :label="`Buscar ${field}...`"
       

        @keydown.enter="search"
      ></v-text-field>
    
      </v-card>
    </v-menu>
  </div>
  <!-- <div class="btn-group">
    {{ title }}
    <a href="javascript:;" data-toggle="dropdown">
      <i class="fa fa-filter" :class="{ 'text-muted': !keyword }"></i>      
    </a>
    <ul class="dropdown-menu" style="padding: 3px">
      <div class="input-group input-group-sm">
        <input type="search" class="form-control" ref="input"
          v-model="keyword" @keydown.enter="search" :placeholder="`Search ${field}...`">
          <span class="input-group-btn">
            <button class="btn btn-default fa fa-search"></button>
          </span>
      </div>
    </ul>
  </div> -->
</template>
<script>
export default {
  props: ['field', 'title', 'query'],
  data: () => ({
    keyword: '',
    menu: false,
    hints: true
  }),
  mounted () {
    jQuery(this.$el).on('shown.bs.dropdown', e => this.$refs.input.focus());
  },
  watch: {
    keyword (kw) {      
      if (kw === '') this.search()
    }
  },
  methods: {
    search () {
      console.log("searching");
      const { query } = this      
      this.$set(query, this.field, this.keyword)
      query.offset = 0
    }
  }
}
</script>
<style>
input[type=search]::-webkit-search-cancel-button {
  -webkit-appearance: searchfield-cancel-button;
  cursor: pointer;
}
</style>
