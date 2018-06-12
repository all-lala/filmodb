import Vue from 'vue'
import PeopleTable from './PeopleTable.vue'
import vueResource from 'Vue-Resource'

Vue.use(vueResource)

new Vue({
  el: '#peoplelist',
  template: '<PeopleTable v-bind:url="url" />',
  beforeMount (){
    this.url = {
      'show': this.$el.attributes['data-show'].value,
      'list': this.$el.attributes['data-list'].value,
      'add': this.$el.attributes['data-add'].value,
      'remove': this.$el.attributes['data-remove'].value.slice(0,-1)
    }
  },
  components: { PeopleTable }
})

