import React from "react";
import logo from "./../assets/logo.png";
import { NavLink } from "react-router";

import { Container, Navbar, Nav, NavDropdown } from "react-bootstrap";

const AppNavbar = () => {
    const navItems = [
        { name: "Home", path: "/" },
        { name: "My Decks", path: "/decks" },
    ];

    return (
        <Navbar collapseOnSelect expand="lg" bg="dark" variant="dark" sticky="top">
            <Container className="m-0">
                <Navbar.Brand as={NavLink} to="/" className="navbar-brand">
                    <img
                        src={logo}
                        width={30}
                        className="d-inline-block align-text-top"
                    />
                    Commander Deck Master
                </Navbar.Brand>
                <Navbar.Toggle aria-controls="basic-navbar-nav"/>
                <Navbar.Collapse id="basic-navbar-nav">
                    <Nav className="navbar-nav">
                        {navItems.map((item) => (
                            <Nav.Link
                                as={NavLink}
                                key={item.path}
                                to={item.path}
                                className="nav-link"
                            >
                                {item.name}
                            </Nav.Link>
                        ))}
                    </Nav>
                </Navbar.Collapse>
            </Container>
        </Navbar>
    );
};

export default AppNavbar;
