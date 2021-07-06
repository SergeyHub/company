export default function ({ store, app, redirect }) {
  // If the user is not authenticated
  if (!store.state.auth.user) {
    return redirect(app.localePath('/'))
  }
}
