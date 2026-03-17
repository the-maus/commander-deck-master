import React from "react";
import logo from "./../assets/logo.png";
import { NavLink } from "react-router";
import { Container, Navbar, Nav, NavDropdown } from "react-bootstrap";
import { PlusCircleFill, ListUl } from "react-bootstrap-icons";
import { useAuth } from "../hooks/useAuth";

const AppNavbar = () => {
    const navItems = [
        { name: "My Decks", path: "/", icon: <ListUl /> },
        {
            name: "New Deck",
            path: "/new-deck",
            icon: <PlusCircleFill className="mb-1" />,
        },
    ];

    const { accessToken } = useAuth();

    return (
        <Navbar
            collapseOnSelect
            expand="lg"
            bg="dark"
            variant="dark"
            sticky="top"
            className="mb-3"
        >
            <Container className="m-0" fluid>
                <Navbar.Brand as={NavLink} to="/" className="navbar-brand">
                    <img
                        src={logo}
                        width={30}
                        className="d-inline-block align-text-top me-2"
                    />
                    Commander Deck Master
                </Navbar.Brand>
                {accessToken && (
                    <>
                        <Navbar.Toggle aria-controls="basic-navbar-nav" />
                        <Navbar.Collapse id="basic-navbar-nav">
                            <Nav className="navbar-nav">
                                {navItems.map((item) => (
                                    <Nav.Link
                                        as={NavLink}
                                        key={item.path}
                                        to={item.path}
                                        className="nav-link"
                                    >
                                        {item.name} {item.icon}
                                    </Nav.Link>
                                ))}
                            </Nav>
                        </Navbar.Collapse>
                    </>
                )}
            </Container>
        </Navbar>
    );
};

export default AppNavbar;
