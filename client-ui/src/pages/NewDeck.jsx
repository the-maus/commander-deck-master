import React, { useState } from "react";
import { Form, Button, Container } from "react-bootstrap";
import { AsyncTypeahead } from "react-bootstrap-typeahead";
import { useCardSearch } from "../hooks/useCardSearch";

const NewDeck = () => {
    const [name, setName] = useState("");
    const [commander, setCommander] = useState("");
    const {options, search, loading} = useCardSearch();

    const handleSubmit = (e) => {
        e.preventDefault();

        const formData = {
            name,
            commander
        };

        console.log(formData);
    };

    return (
        <Container className="mt-4">
            <Form onSubmit={handleSubmit}>
                <Form.Group className="mb-3" controlId="name">
                    <Form.Label>Name</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Enter the deck name"
                        value={name}
                        onChange={(e) => setName(e.target.value)}
                    />
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Commander</Form.Label>
                    <AsyncTypeahead
                        id="commander-autocomplete"
                        isLoading={loading}
                        onSearch={search}
                        options={options}
                        placeholder="Type your commander name..."
                        onChange={setCommander}
                        selected={commander}
                        clearButton
                    />
                </Form.Group>

                <Button variant="primary" type="submit">
                    Create
                </Button>
            </Form>
        </Container>
    );
};

export default NewDeck;
