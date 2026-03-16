import React, { useEffect, useRef, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import { Form, Button, Container, Alert, Row, Col } from "react-bootstrap";
import { AsyncTypeahead } from "react-bootstrap-typeahead";
import { useCardSearch } from "../hooks/useCardSearch";
import api from "../services/api";
import Loading from "../components/Loading";

const EditDeck = () => {
    const [id, setId] = useState(null);
    const [name, setName] = useState("");
    const [commanderName, setCommanderName] = useState(['']);
    const { options, search, loading: cardLoading } = useCardSearch();
    const [errors, setErrors] = useState([]);
    const navigate = useNavigate();
    const commanderNameInput = useRef();
    const [loading, setLoading] = useState(false);

    const { deckId } = useParams();

    useEffect(() => {
        loadDeck();
    }, []);

    async function loadDeck() {
        try {
            setLoading(true);
            const response = await api.get(`/decks/${deckId}`);

            console.log(response);

            setId(response.data.data.id);
            setName(response.data.data.name);
            setCommanderName([response.data.data.commander_name]);

            setLoading(false);
        } catch (error) {
            console.log(error.response);
        }
    }

    const editDeck = async (e) => {
        e.preventDefault();
        setLoading(true);
        let commander_name =
            commanderNameInput.current.state.selected.length === 0
                ? commanderNameInput.current.state.text
                : commanderNameInput.current.state.selected[0];
        setErrors([]);
        const formData = { id, name, commander_name };
        console.log(formData);
        try {
            await api.put(`/decks/${id}`, formData);
            navigate("/");
        } catch (error) {
            if (error.response && error.response.status === 422) {
                setErrors(error.response.data.errors);
            } else {
                console.log(error.response.data);
                setErrors({ commander_name: [error.response.data.message] });
            }
        }
        setLoading(false);
    };

    return (
        <>
            <Container className="mt-4">
                <h1>Edit Deck</h1>
                <hr />
                <Form onSubmit={editDeck}>
                    <input type="hidden" name="id" value={id} />
                    <Form.Group className="mb-3" controlId="name">
                        <Form.Label>Name</Form.Label>
                        <Form.Control
                            type="text"
                            placeholder="Enter the deck name"
                            value={name}
                            onChange={(e) => setName(e.target.value)}
                        />
                    </Form.Group>
                    {errors.name && (
                        <Alert key="name" variant="danger" className="mt-3">
                            {errors.name[0]}
                        </Alert>
                    )}

                    <Form.Group className="mb-3">
                        <Form.Label>Commander</Form.Label>
                        <AsyncTypeahead
                            id="commander-autocomplete"
                            isLoading={cardLoading}
                            ref={commanderNameInput}
                            onSearch={search}
                            options={options}
                            selected={commanderName}
                            onChange={setCommanderName}
                            placeholder="Type your commander name..."
                            clearButton
                        />
                    </Form.Group>
                    {errors.commander_name && (
                        <Alert key="danger" variant="danger" className="mt-3">
                            {errors.commander_name[0]}
                        </Alert>
                    )}
                    <Container>
                        <Row className="align-items-center">
                            <Col className="text-center">
                                <Button
                                    variant="secondary"
                                    className="me-2"
                                    onClick={() => navigate("/")}
                                >
                                    Back
                                </Button>
                                <Button type="submit" variant="primary">
                                    Save
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

export default EditDeck;
