import Vue from 'vue'
import MovieTable from './MovieTable.vue'
import vueResource from 'Vue-Resource'

Vue.use(vueResource)

new Vue({
  el: '#movielist',
  template: '<MovieTable v-bind:url="url" />',
  beforeMount (){
    this.url = {
      'show': this.$el.attributes['data-show'].value,
      'list': this.$el.attributes['data-list'].value,
      'add': this.$el.attributes['data-add'].value,
      'remove': this.$el.attributes['data-remove'].value.slice(0,-1)
    }
  },
  components: { MovieTable }
})

