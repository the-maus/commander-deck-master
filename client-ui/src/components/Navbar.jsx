import React from "react";
import logo from "./../assets/logo.png";
import { NavLink } from "react-router";
import { Container, Navbar, Nav, NavDropdown, Dropdown, Button } from "react-bootstrap";
import { PlusCircleFill, ListUl, PersonCircle, BoxArrowRight } from "react-bootstrap-icons";
import { useAuth } from "../context/AuthContext";

const AppNavbar = () => {
    const navItems = [
        { name: "My Decks", path: "/", icon: <ListUl /> },
        {
            name: "New Deck",
            path: "/new-deck",
            icon: <PlusCircleFill className="mb-1" />,
        },
    ];

    const { user, logout } = useAuth();

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
                        className="d-inline-block align-text-top me-1"
                    />
                    Commander Deck Master
                </Navbar.Brand>
                {user && (
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
                                        {item.icon} {item.name}
                                    </Nav.Link>
                                ))}
                                <NavDropdown
                                    title={
                                        <span>
                                            <PersonCircle className="mb-1" />{" "}
                                            {user.name}
                                        </span>
                                    }
                                    id="navbarScrollingDropdown"
                                >
                                    <NavDropdown.Item className="nav-link ms-3" onClick={() => logout()}>
                                        <BoxArrowRight /> Logout
                                    </NavDropdown.Item>
                                    {/* <NavDropdown.Divider /> */}
                                    {/* <NavDropdown.Item href="#action5">
                                        Something else here
                                    </NavDropdown.Item> */}
                                </NavDropdown>
                            </Nav>
                        </Navbar.Collapse>
                    </>
                )}
            </Container>
        </Navbar>
    );
};

export default AppNavbar;
