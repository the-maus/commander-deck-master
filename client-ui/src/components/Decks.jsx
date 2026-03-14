import React, { useEffect, useState } from "react";
import { Container, Row, Col, Card, Button } from "react-bootstrap";
import api from "../services/api";

const Decks = () => {
    const [decks, setDecks] = useState([]);
    const [page, setPage] = useState(1);
    const [nextPage, setNextPage] = useState(true);
    const [prevPage, setPrevPage] = useState(false);
    const [loading, setLoading] = useState(false);

    const loadDecks = async () => {
        setLoading(true);

        const response = await api.get("/decks", {
            params: { page: page },
        });
        console.log(response);
        setDecks(response.data.data.data);

        response.data.data.last_page == page
            ? setNextPage(false)
            : setNextPage(true);
        page > 1 ? setPrevPage(true) : setPrevPage(false);

        setLoading(false);
    };

    useEffect(() => {
        loadDecks();
    }, [page]);

    return (
        <>
            {!loading && (
                <Container fluid>
                    <Row>
                        {decks &&
                            decks.map((deck) => (
                                <Col md={6} className="mb-4">
                                    <Card>
                                        <img
                                            src={deck.art_crop}
                                            className="card-img-top"
                                            alt="Image 1"
                                        />
                                        <Card.Body>
                                            <Card.Title className="card-title text-primary">
                                                {deck.name}
                                            </Card.Title>
                                            <Card.Text>
                                                {deck.commander_name}
                                            </Card.Text>
                                        </Card.Body>
                                    </Card>
                                </Col>
                            ))}
                    </Row>
                    {/* <Container fluid>
                        <Row>
                            <Col>
                                {prevPage && (
                                    <Button variant="primary" onClick={() => setPage(page - 1)}>Back</Button>
                                )}
                            </Col>
                            <Col>
                                {nextPage && (
                                    <Button variant="primary" onClick={() => setPage(page + 1)}>Next</Button>
                                )}
                            </Col>
                        </Row>
                    </Container> */}
                    <Container>
                        <Row className="align-items-center">
                            <Col className="text-center">
                                {prevPage && (
                                    <Button variant="secondary" className="me-2" onClick={() => setPage(page - 1)}>
                                        Back
                                    </Button>
                                )}
                                {nextPage && (
                                    <Button variant="primary" onClick={() => setPage(page + 1)}>Next</Button>
                                )}
                            </Col>
                        </Row>
                    </Container>
                </Container>
            )}
            {loading && <h1>Carregando...</h1>}
        </>
    );
};

export default Decks;
