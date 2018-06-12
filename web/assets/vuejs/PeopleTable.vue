<template>
    <div>
        <div class="row" v-if="loadingData">CHARGEMENT EN COURS!</div>
        <div v-else>
            <div class="row">
                <div class="col-md-3">
                    Par page :
                    <select v-model="actualPerPage" @change="getpeoples">
                        <option v-for="(num, key) in perpage" :value="num" :key="key" >{{num}}</option>
                    </select>
                </div>
                <div class="col-md 2 offset-md-7">
                    <input type="text" v-model="search" placeholder="Rechercher">
                    <button class="float-right" @click="getpeoples">Rechercher</button>
                </div>
            </div>
            <table class="table table-condensed table-striped">
                <thead>
                    <tr>
                        <th class="col-md-9">Nom prénom</th>
                        <th class="col-md-2">Année de naissance</th>
                        <th class="col-md-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(people, key) in peoples" :key="key">
                        <td>{{ people.fullName }}</td>
                        <td>{{ people.birthdate }}</td>
                        <td><a :href="url.show + people.id">Voir</a></td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="btn-group text-center" role="group">
                    <button
                        v-for="(page, key) in listPages"
                        :key="key" type="button"
                        class="btn btn-secondary"
                        :class="{ active : actualPage == page }"
                        @click="changePage(page)">{{ page }}</button>
                </div>
                <div></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'peopleTable',
        props : ['url'],
        data () {
            return {
                loadingData: false,
                peoples: [],
                total: 0,
                perpage: [5,10,20,50],
                actualPage: 1,
                actualPerPage: 20
            }
        },
        mounted (){
            this.getpeoples()
        },
        computed : {
            listPages () {
                let pages = []
                let nbpage = Math.floor(this.total/this.actualPerPage)
                if(this.total%this.actualPerPage){
                    nbpage++
                }
                for(let i = 1; i <= nbpage; i++){
                    pages.push(i)
                }

                return pages
            }
        },
        methods : {
            changePage (page) {
                this.actualPage = page
                this.getpeoples()
            },
            getpeoples () {
                this.loadingData = true
                this.$http.get(this.url.list,
                    {params:
                        {
                            page: this.actualPage,
                            pageby: this.actualPerPage
                        }
                    }
                ).then(
                    (datas)=>{
                        this.peoples = datas.body.peoples
                        this.total = datas.body.total
                        this.loadingData = false
                    },
                    (error)=>{
                        console.log(error)
                    }
                )
            },
            show () {

            }
        }
    }
</script>
