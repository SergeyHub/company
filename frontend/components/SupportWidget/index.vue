<template>
  <script type="text/javascript">
    (function(w,d){
      w.HelpCrunch=function(){w.HelpCrunch.q.push(arguments)};w.HelpCrunch.q=[];
      function r(){var s=document.createElement('script');s.async=1;s.type='text/javascript';s.src='https://widget.helpcrunch.com/';(d.body||d.head).appendChild(s);}
      if(w.attachEvent){w.attachEvent('onload',r)}else{w.addEventListener('load',r,false)}
    })(window, document)
  </script>
</template>
<script>
export default {
  mounted() {
    HelpCrunch('init', 'onenight', {
      applicationId: 4,
      applicationSecret: 'bwpczX2m55NMgaik7SeC6pJvWwoed91Esm8txMNSXNpQQPqyierE27CivJovwbHdlkKkPNQ+GyfxX0jLMn7hog=='
    })

    HelpCrunch('showChatWidget');
    HelpCrunch('setPhraseList', this.$i18n.locale)
  }
}
</script>
