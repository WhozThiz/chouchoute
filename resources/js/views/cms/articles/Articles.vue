<template>
  <div class="app-container">
    <split-pane split="vertical" @resize="resize">
      <template slot="paneL">
        <articles-list :articles="articles" />
      </template>
      <template slot="paneR">
        <split-pane split="horizontal">
          <template slot="paneL">
            <create-article />
          </template>
          <template slot="paneR">
            <div class="bottom-container" />
          </template>
        </split-pane>
      </template>
    </split-pane>
  </div>
</template>

<script>
import splitPane from 'vue-splitpane';
import ArticlesList from './components/List.vue';
import CreateArticle from './components/Create.vue';

export default {
  components: { splitPane, ArticlesList, CreateArticle },

  data() {
    return {
    };
  },

  created() {
  },

  methods: {
    resize() {
      console.log('resize');
    },
  },
};
</script>

<style  scoped>
  .components-container {
    position: relative;
    height: 100vh;
  }

  .left-container {
    background-color: #F38181;
    height: 100%;
  }

  .right-container {
    background-color: #FCE38A;
    height: 200px;
  }

  .top-container {
    background-color: #FCE38A;
    width: 100%;
    height: 100%;
  }

  .bottom-container {
    width: 100%;
    background-color: #95E1D3;
    height: 100%;
  }
</style>
