export default function ({ store, app, redirect }) {
  const type =  store.state.auth.user.type;

  if (type === 'client')
    return;

  if (type === 'girl')
    return redirect(app.localePath('profile'))

  return redirect(app.localePath('profile-agency'))
}
