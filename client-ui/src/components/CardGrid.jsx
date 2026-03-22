import { Container, Row, Col, Card, Badge } from "react-bootstrap";

const CardGrid = ({ cards, onClick }) => {
    return (
        <Container fluid className="cardsGrid">
            {Object.entries(cards).map(
                ([id, type]) =>
                    type.items.length > 0 && (
                        <>
                            <Col>
                                <h6>{type.label} ({type.count})</h6>
                            </Col>
                            <Row
                                key={id}
                                xs={2}
                                sm={3}
                                md={4}
                                lg={6}
                                xl={7}
                                className="g-1 mb-5"
                                style={{"padding-top": "180px"}}
                            >
                                {type.items.map((card) => (
                                    <Col key={card.id} onClick={() => onClick(card)}>
                                        <div className="position-relative">
                                            <Card className="shadow-sm border-0" style={{"margin-top": "-180px", "margin-botton": "unset"}}>
                                                <Card.Img
                                                    variant="top"
                                                    src={card.image_url}
                                                    alt={card.name}
                                                    style={{
                                                        objectFit: "cover",
                                                        height: "100%",
                                                    }}
                                                    className="rounded"
                                                />
                                            </Card>

                                            {/* Count badge */}
                                            {card.quantity > 1 && (
                                                <Badge
                                                    bg="dark"
                                                    className="position-absolute top-0 end-0 m-1 rounded"
                                                >
                                                    x{card.quantity}
                                                </Badge>
                                            )}
                                        </div>
                                    </Col>
                                ))}
                            </Row>
                        </>
                    ),
            )}
        </Container>
    );
};

export default CardGrid;
