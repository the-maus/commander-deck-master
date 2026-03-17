import React, { useRef, useState } from "react";
import { useNavigate } from "react-router-dom";
import { Form, Button, Container, Alert, Row, Col } from "react-bootstrap";
import api from "../services/api";
import { Plus } from "react-bootstrap-icons";
import Loading from "../components/Loading";
import { useAuth } from "../hooks/useAuth";

const Login = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState("");
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const {setAccessToken} = useAuth();

    const login = async (e) => {
        e.preventDefault();

        setLoading(true);

        const data = {email, password};

        try {
            const response = await api.post('/login', data);
            // setAuth(response.data.user.name, response.data.access_token);
            setAccessToken(response.data.access_token);

            navigate('/');
        } catch (error) {
            console.log(error)
            setError(error.response.data.message);
        }

        setLoading(false);
    };

    return (
        <>
            <Container className="mt-4">
                <h1>Login</h1>
                <hr />
                {error && (
                    <Alert key="email" variant="danger" className="mt-3">
                        {error}
                    </Alert>
                )}
                <Form onSubmit={login}>
                    <Form.Group className="mb-3" controlId="name">
                        <Form.Label>E-mail</Form.Label>
                        <Form.Control
                            type="text"
                            placeholder="Enter your e-mail"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            required
                        />
                    </Form.Group>
                    

                    <Form.Group className="mb-3" controlId="name">
                        <Form.Label>Password</Form.Label>
                        <Form.Control
                            type="password"
                            placeholder="Enter your password"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                            required
                        />
                    </Form.Group>
                    <Container>
                        <Row className="align-items-center">
                            <Col className="text-center">
                                <Button type="submit" variant="primary">
                                    Login
                                </Button>
                            </Col>
                        </Row>
                    </Container>
                </Form>
            </Container>

            {loading && <Loading />}
        </>
    );
};

export default Login;
