import React from "react";
import logo from "./../assets/logo.png";
import { NavLink } from "react-router";

const Navbar = () => {
	const navItems = [
		{ name: "Home", path: "/" },
		{ name: "My Decks", path: "/decks" },
	];

	return (
		<nav className="navbar navbar-expand-lg fixed-top ">
			<div className="container-fluid">
				<NavLink to="/" className="navbar-brand">
					<img src={logo} width={30} className="d-inline-block align-text-top" /> Commander Deck Master
				</NavLink>
				<button
					className="navbar-toggler"
					type="button"
					data-bs-toggle="collapse"
					data-bs-target="#navbarNavAltMarkup"
					aria-controls="navbarNavAltMarkup"
					aria-expanded="false"
					aria-label="Toggle navigation"
				>
					<span className="navbar-toggler-icon"></span>
				</button>
				<div className="collapse navbar-collapse" id="navbarNavAltMarkup">
					<div className="navbar-nav">
            {navItems.map((item) => (
              <NavLink key={item.path} to={item.path} className="nav-link">{item.name}</NavLink>
            ))}
          </div>
				</div>
			</div>
		</nav>
	);
};

export default Navbar;
