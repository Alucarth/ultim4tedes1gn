<template>
  <div class="btn-group">
    {{ title }}
    <a href="javascript:;" data-toggle="dropdown">
      <i class="fa fa-filter" :class="{ 'text-muted': !keyword }"></i>
    </a>
    <ul class="dropdown-menu" style="padding: 3px">
      <div class="input-group input-group-sm">       
      </div>
    </ul>
  </div>
</template>
<script>
export default {
  props: ['field', 'title', 'query'],
  data: () => ({
    keyword: ''
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
