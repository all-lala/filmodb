<template>
    <div>
        <div class="row" v-if="loadingData">CHARGEMENT EN COURS!</div>
        <div v-else>
            <div class="row">
                <div class="col-md-3">
                    Par page :
                    <select v-model="actualPerPage" @change="getMovies">
                        <option v-for="(num, key) in perpage" :value="num" :key="key" >{{num}}</option>
                    </select>
                </div>
                <div class="col-md 2 offset-md-7">
                    <input type="text" v-model="search" placeholder="Rechercher">
                    <button class="float-right" @click="getMovies">Rechercher</button>
                </div>
            </div>
            <table class="table table-condensed table-striped">
                <thead>
                    <tr>
                        <th class="col-md-9">Titre</th>
                        <th class="col-md-2">Année</th>
                        <th class="col-md-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(movie, key) in movies" :key="key">
                        <td>{{ movie.title }}</td>
                        <td>{{ movie.year}}</td>
                        <td><a :href="url.show + '/' + movie.id">Voir</a></td>
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
        name: 'MovieTable',
        props : ['url'],
        data () {
            return {
                loadingData: false,
                movies: [],
                total: 0,
                perpage: [5,10,20,50],
                actualPage: 1,
                actualPerPage: 20
            }
        },
        mounted (){
            this.getMovies()
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
                this.getMovies()
            },
            getMovies () {
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
                        this.movies = datas.body.movies
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
