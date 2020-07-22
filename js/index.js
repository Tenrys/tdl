import IndexPage from "./pages/index";
import UsersPage from "./pages/users";

for (const [page, app] of Object.entries({ index: IndexPage, users: UsersPage })) {
	const slug = (location.pathname.match(/\/(.*).php$/) || [, "index"])[1];
	console.log(slug);
	if (slug == page && document.querySelector(`#${page}`)) {
		app.$mount(`#${page}`);
	}
}
