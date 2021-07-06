<template>
  <div class="accord detail-block detail-block-about"
       :class="opened ? '' : 'detail-block-closed'">
    <div class="detail-block-header accord_header" @click="opened=!opened">
      <div class="title">
        <i class="fas" :class="icon"></i>
        <slot name="title"></slot>
      </div>
      <div class="detail-block-header-right">
        <i class="fas fa-angle-down"></i>
      </div>
    </div>
    <b-collapse v-model="opened" :id="id">
      <div class="detail-block-body accord_content">
        <slot name="body"></slot>
      </div>
    </b-collapse>
  </div>
</template>

<script>
  import { randomString } from '~/utils'
  export default {
    props: {
      icon: {
        type: String,
        default: () => 'fa-file-alt'
      },
      id: {
        type: String,
        default: () => randomString(5)
      }
    },
    data() {
      return {
        opened: true
      }
    }
  }
</script>


<style>
  .detail-block.accord {
    border: none;
    width: 100%;
    margin-bottom: 15px;
    box-shadow: inset 0 -1px 0 0 rgba(0,0,0,0.1), 0 2px 5px 0 rgba(19,41,104,0.2);
    background-color: #fff;
    border-radius: 8px;
  }
  .detail-block.accord .accord_header {
    border-top: 1px solid rgba(0,0,0,.125);
    background-image: none;
    height: unset;
    border-top-right-radius: 8px;
    border-top-left-radius: 8px;
  }
  .detail-block .detail-block-header {
    padding: 13px 19px 12px;
    background-color: rgba(0,0,0,.04);
    box-shadow: inset 0 -1px 0 0 rgba(0,0,0,.1);
    font-size: 14px;
    letter-spacing: -.4px;
    color: #4a4a4a;
    cursor: pointer;
    display: -webkit-box;
    display: -ms-flexbox;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    text-transform: capitalize;
    display: flex;
  }
  .detail-block .detail-block-body {
    padding: 17px 15px 18px;
    font-size: 14px;
  }
  .detail-block .detail-block-header .title, .detail-block .detail-block-header h2 {
    display: block;
    font-weight: 400;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 18px;
    line-height: 23px;
    padding: 0;
    margin: 0;
  }
  .detail-block .detail-block-header h2 {
    display: inline;
    color: #4a4a4a;
    font-family: 'GTWalsheimPro';
  }
  .detail-block .detail-block-header .detail-block-header-right {
    float: right;
    display: block;
    position: relative;
    top: -2px;
    white-space: nowrap;
  }

  .detail-block .detail-block-header i {
    margin-right: 13px;
  }

  .detail-block .detail-block-header .detail-block-header-right i {
    margin-right: 0;
    margin-left: 9px;
    position: relative;
    top: 4px;
    font-size: 22px;
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  .detail-block.detail-block-closed .detail-block-header-right i {
    -webkit-transform: rotate(-90deg);
    transform: rotate(-90deg);
  }
</style>
