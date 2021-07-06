export default function ({ store, app, redirect }) {
  const type =  store.state.auth.user.type;

  if (type === 'agency')
    return;

  if (type === 'client')
    return redirect(app.localePath('profile-client'))

  return redirect(app.localePath('profile'))
}
