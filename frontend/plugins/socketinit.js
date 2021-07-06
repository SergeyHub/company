import Socket from '~/utils/socket'

export default function ({ app }) {
  var initSocket = () => {
    window.socket = new Socket(
      app.store.getters['auth/loggedUser'].id,
      app.store.state.auth.token,
      app
    );
  };

  if(app.store.getters['auth/isAuthentificated']) {
    initSocket();
  } else {
    app.store.watch(state => state.auth.token, (newVal, prevVal) => {
      if(newVal) {
        initSocket();
      } else {
        if(window.socket)
          window.socket.disconnect();
        window.socket = null;
      }
    })
  }
}
