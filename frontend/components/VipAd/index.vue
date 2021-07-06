<template>
  <div class="row">
    <div class="admin-be-vip">
      <div class="be-vip-promoline">
        <div class="promo-light"></div>
        <div class="promo-in"></div>
        <div class="promo-yellow-content">
          <span class="multiplier">20x </span>
          <span class="yellow-span"> More Visitors</span>
        </div>
        <div class="promo-brown-text global-text">
          <p>Be a VIP AGENCY</p>
        </div>
        <div class="promo-brown-button">Advertise Now</div>
      </div>
    </div>
  </div>
</template>

<style>
  .admin-be-vip {
    width: 100%;
  }
  .be-vip-promoline {
    height: 97px;
    overflow: hidden;
    background: #7b5e21;
    position: relative;
    border-radius: 5px;
    cursor: pointer;
    margin: 0 auto 11px;
  }
  .be-vip-promoline .promo-light {
    position: absolute;
    top: -188px;
    left: 150px;
    width: 375px;
    height: 375px;
    border-radius: 375px;
    opacity: .35;
    background-image: radial-gradient(ellipse at center,#fff 0,hsla(0,0%,100%,0) 70%);
    mix-blend-mode: overlay;
    z-index: 20;
  }
  .be-vip-promoline .promo-in {
    width: 600px;
    height: 500px;
    border-radius: 500px;
    background: #f7bd43;
    position: absolute;
    left: -150px;
    top: -316px;
    z-index: 10;
  }
  .be-vip-promoline .promo-yellow-content {
    position: absolute;
    z-index: 30;
    font-size: 36px;
    font-weight: 700;
    color: #fff;
    height: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    padding-left: 35px;
  }
  .be-vip-promoline .promo-brown-button {
    position: absolute;
    width: 143px;
    height: 40px;
    border-radius: 6px;
    background-color: #fff;
    right: 30px;
    top: 30px;
    font-size: 16px;
    text-align: center;
    color: #7b5d21;
    line-height: 40px;
    cursor: pointer;
  }
</style>
