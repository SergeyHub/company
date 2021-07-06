<template>
  <router-link class="agency-item row" :to="localePath({name: 'agencies-id', params: {id: agency.id}})">
    <div class="agency-item-info col-xl-5 col-12 mb-2">
      <div class="agency-item-info-header">
        <div class="agency-item-agency-name">
            <h3>{{agency.name}}</h3>
        </div>
        <div class="agency-item-badges">
          <span class="badge badge-gray">{{$t('agencies.girls')}}: {{agency.girls.length}}</span>
        </div>
      </div>
      <div class="agency-item-intro about-me-translated mb-2">
        {{agency.description}}</div>
    </div>
    <div class="col-xl-7 col-12">
      <div class="agency-item-girls-img">
        <img v-for="(girl, index) in agency.girls" :src="girl.avatar" :key="index" v-if="index < 4" :class="'agency-girl-photo-'+index">
      </div>
    </div>
  </router-link>
</template>

<script>
  export default {
    props: {
      agency: {
        type: Object,
        default: () => {}
      }
    }
  }
</script>

<style lang="scss">
  .agencies-container .agency-item {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid #e5e5e5;
    overflow-x: hidden;
    margin-left: 0;
    margin-right: 0;
  }

  .agencies-container .agency-item .agency-item-info {
    padding-right: 30px;
  }

  .agencies-container .agency-item .agency-item-info .agency-item-info-header {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
  }

  .agencies-container .agency-item .agency-item-info .agency-item-intro {
    opacity: .7;
    font-family: Helvetica Neue,Helvetica,Arial,sans-serif;
    font-size: 14px;
    line-height: 1.57;
    color: #444;
  }

  .agencies-container .agency-item .agency-item-girls-img {
    width: 100%;
    overflow-x: hidden;
    flex: none;
    img {
      max-width: 85px;
      max-height: 150px;
      float: left;
      margin-right: 10px;
    }
  }

  .agencies-container .agency-item .agency-item-info .agency-item-info-header .agency-item-agency-name {
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
    min-width: 0;
  }

  .agencies-container .agency-item .agency-item-info .agency-item-info-header .agency-item-agency-name a h3 {
    font-family: Oswald;
    font-size: 30px;
    letter-spacing: -.35px;
    color: #303030;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
  }

  .agencies-container .agency-item .agency-item-info .agency-item-info-header .agency-item-badges .badge {
    font-family: Helvetica,Arial,sans-serif;
    padding: 4px 6px;
    margin-left: 5px;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    border-radius: 2px;
    background-color: #6b737a;
  }
</style>
