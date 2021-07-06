export default function ({ store, app, redirect }) {
  if (!store.getters['auth/isAdmin']) {
    return redirect(app.localePath('/'))
  }
}
