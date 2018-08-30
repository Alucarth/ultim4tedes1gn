<template>
  <div class="-nested-dsp-row-comp">
    <button class="btn btn-xs btn-link -nested-dsp-row-close-btn"
      @click="nested.$toggle(false)">
      <i class="fa fa-times fa-lg"></i>
    </button>
    <dl class="dl-horizontal">
      <div class="row">
        <div class="col-md-6">Identificador</div>
        <div class="col-md-6">{{row.id}}</div>
      </div>
      <div class="row">
        <div class="col-md-6">Alto</div>
        <div class="col-md-6">{{row.high}}</div>
      </div>
      <div class="row">
        <div class="col-md-6">Ancho</div>
        <div class="col-md-6">{{row.wide}}</div>
      </div>
      <div class="row">
        <div class="col-md-6">Largo</div>
        <div class="col-md-6">{{row.length}}</div>
      </div>
      <div class="row">
        <div class="col-md-6">Calidad</div>
        <div class="col-md-6">{{row.quality}}</div>
      </div>
      <div class="row">
        <div class="col-md-6">Especie</div>
        <div class="col-md-6">{{row.specie}}</div>
      </div>
      <div class="row">
        <div class="col-md-6">Descripci&oacute;n</div>
        <div class="col-md-6">{{row.description}}</div>
      </div>
    </dl>
  </div>
</template>
<script>
export default {
  props: ['row', 'nested'],
  mounted () {    
   
    console.log("asdfasdf");
    console.log(this.row.description);
    //console.log(this.row);
    // jQuery(this.$el).find('button[title]').tooltip();
  }
}
</script>
<style>
.-nested-dsp-row-comp {
  position: relative;
  padding: 10px;
}
.-nested-dsp-row-close-btn {
  position: absolute;
  top: 5px;
  right: 5px;
}
</style>
