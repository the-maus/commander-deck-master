import React, { useRef, useState } from "react";
import { useNavigate } from "react-router-dom";
import { Form, Button, Container, Alert, Row, Col } from "react-bootstrap";
import { AsyncTypeahead } from "react-bootstrap-typeahead";
import { useCardSearch } from "../hooks/useCardSearch";
import api from "../services/api";
import { Plus } from "react-bootstrap-icons";
import Loading from "../components/Loading";

const NewDeck = () => {
    const [name, setName] = useState("");
    const { options, search, loading: cardLoading } = useCardSearch();
    const [errors, setErrors] = useState([]);
    const navigate = useNavigate();
    const commanderNameInput = useRef();
    const [loading, setLoading] = useState(false);

    const saveDeck = async (e) => {
        e.preventDefault();

        setLoading(true);

        let commander_name =
            commanderNameInput.current.state.selected.length === 0
                ? commanderNameInput.current.state.text
                : commanderNameInput.current.state.selected[0];

        setErrors([]);

        const formData = { name, commander_name };
        console.log(formData);

        try {
            await api.post("/decks", formData);
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
                <h1>Create Deck</h1>
                <hr />
                <Form onSubmit={saveDeck}>
                    <Form.Group className="mb-3" controlId="name">
                        <Form.Label>Name</Form.Label>
                        <Form.Control
                            type="text"
                            placeholder="Enter the deck name"
                            value={name}
                            onChange={(e) => setName(e.target.value)}
                            required
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

export default NewDeck;
