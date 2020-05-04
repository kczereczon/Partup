<template>
    <transition name="fade">
        <div class="loader">
        <p class="loading">Loading <span>.</span><span>.</span><span>.</span></p>
    </div>
    </transition>
</template>

<style>
.loader {
    display: flex;
    width: 100%;
    height: 100%;
    justify-content: center;
    align-items: center;
}
.loading span{
    font-size: 2em;
    display: inline-block;
    animation-name: dots;
    animation-duration: 1.4s;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
}
.loading span:nth-child(2){
    animation-delay: 0.4s;
}
.loading span:nth-child(3){
    animation-delay: 0.8s;
}
@keyframes dots {
    20%{
        transform: translateY(0px);
    }
    50%{
        transform: translateY(-15px);
    }
}
.loading {
    font-size: 2em;
    color: var(--gray);
    font-weight: bolder;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
